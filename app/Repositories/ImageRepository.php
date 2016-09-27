<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Models\Image as ImageModel;
use App\Repositories\CategoryRepository;
use App\Repositories\SettingRepository;
use App;
use Cache;

/**
 * Welcome Repository
 *
 * Repository for custom methods of index Page
 *
 * @package   Repositories
 * @author    Den
 */
class ImageRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(ImageModel $model, CategoryRepository $category, SettingRepository $setting) {

        $this->model = $model;
        $this->category = $category;
        $this->countPerPage = 10;
        $this->setting = $setting;
    }

    public function getImagesByAlbomId($albomId) {

        return $this->model
                        ->where('visible', 1)
                        ->where('albom_id', $albomId)
                        ->orderBy('id', 'desc')
                        ->paginate(200);
    }

    public function getAllImagesByAlbomId($albomId) {
        return Cache::remember('images' . $albomId, 60, function() use ($albomId) {
                    return $this->model
                                    ->where('visible', 1)
                                    ->where('albom_id', $albomId)
                                    ->orderBy('id', 'desc')
                                    ->get();
                });
    }

    public function getAllVisibleImages() {

        return $this->model
                        ->where('visible', 1)
                        ->whereHas('albom', function($query) {
                            $query->where('visible', 1);
                            $query->whereHas('categories', function($query2) {
                                $query2->where('visible', 1);
                            });
                        })
                        ->get();
    }

    public function getImageBySlug($imageSlug) {
        return $this->model
                        ->where('visible', 1)
                        ->whereHas('albom', function($query) {
                            $query->where('visible', 1);
                            $query->whereHas('categories', function($query2) {
                                $query2->where('visible', 1);
                            });
                        })
                        ->where('slug', $imageSlug)
                        ->with('albom')
                        ->first();
    }

    public function checkImageExistBySlug($imageSlug) {
        $img = $this->model
                ->where('slug', $imageSlug)
                ->get()
                ->first();
        if (isset($img->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function oneImage($imageSlug) {
        $thisImage = $this->getImageBySlug($imageSlug);
        if (!$thisImage) {
            App::abort(404);
        }
        $thisAlbom = $thisImage->albom;
        $nextPreviousImages = $this->getNextPreviousImages($thisImage->id);
        $nextImage = $nextPreviousImages['next'];
        $previousImage = $nextPreviousImages['previous'];

        $lastCategory = $thisAlbom->categories->first();

        $categories = $this->category->getAllVisibleCategories();

        $settings = $this->setting->getAllSettings();
        $data = ['albom' => $thisAlbom,
            'image' => $thisImage,
            'categories' => $categories,
            'settings' => $settings,
            'lastCatSlug' => $lastCategory->slug,
            'categoryTitle' => $lastCategory->title,
            'nextImage' => $nextImage,
            'previousImage' => $previousImage
        ];

        return $data;
    }

    private function getNextPreviousImages($imageId) {
        $next = $this->model
                ->where('id', '<', $imageId)
                ->orderBy('id', 'desc')
                ->take(1)
                ->get()
                ->first();

        $previous = $this->model
                ->where('id', '>', $imageId)
                ->orderBy('id', 'asc')
                ->take(1)
                ->get()
                ->first();
        if (!$previous) {
            $previous = $this->model
                    ->orderBy('id', 'asc')
                    ->take(1)
                    ->get()
                    ->first();
        }

        return ['next' => $next, 'previous' => $previous];
    }

    public function getImagesPaginated() {
        $count = $this->countPerPage;
        $images = $this->model
                ->with('albom')
                ->paginate($count);
        return $images;
    }

    public function pageCount() {
        return ceil($this->model->count() / $this->countPerPage);
    }

    public function pageCountWithAlbomId($id) {
        return ceil($this->model->where('albom_id', $id)->count() / $this->countPerPage);
    }

    public function changeImageAlbom($albomId, $imageId) {
        return $this->model->where('id', '=', $imageId)->update(['albom_id' => $albomId]);
    }

    public function getFilteredImageData($limit, $albom, $sort = 'desc', $offset = 0) {
        $images = $this->model
                ->whereHas('albom', function($query) use ($albom) {
                    if ($albom != '') {
                        $query->where('id', $albom);
                    }
                })
                ->with(['albom' => function($query) use ($albom) {
                        if ($albom != '') {
                            $query->where('id', $albom);
                        }
                    }])
                ->orderBy('id', $sort)
                ->take($limit)
                ->skip($offset)
                ->get();

        return ['images' => $images, 'limit' => $limit, 'albSel' => $albom, 'sort' => $sort];
    }

    public function checkIsSetImageByImage($url) {
        $image = $this->model
                ->where('url', $url)
                ->get()
                ->first();
        if (isset($image->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function getWhereEmptyMeta($albomId, $count, $flag = false) {
        return $this->model
                        ->where(function($query) {

                            $query->orWhere('description', '');
                            $query->orWhere('content', '');
                            $query->orWhere('title', '');
                        })
                        ->where(function($query) use ($flag, $albomId) {

                            if (!$flag) {
                                $query->where('albom_id', $albomId);
                            }
                        })
                        ->take($count)
                        ->get();
    }

    public function isExistThisMeta($albomId, $title, $descr, $content, $flag = false) {
        $image = $this->model
                ->where(function($query) use ($descr, $title, $content ) {

                    $query->orWhere('description', $descr);
                    $query->orWhere('content', $content);
                    $query->orWhere('title', $title);
                })
                ->where(function($query) use ($flag, $albomId) {

                    if (!$flag) {
                        $query->where('albom_id', $albomId);
                    }
                })
                ->get()
                ->first();
        if (isset($image->id)) {
            return true;
        } else {
            return false;
        }
    }

}

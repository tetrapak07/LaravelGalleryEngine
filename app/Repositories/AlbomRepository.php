<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Models\Albom as AlbomModel;
use App\Repositories\PageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ImageRepository;
use App\Repositories\SettingRepository;
use App;

/**
 * Welcome Repository
 *
 * Repository for custom methods of index Page
 *
 * @package   Repositories
 * @author    Den
 */
class AlbomRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(
    AlbomModel $model, PageRepository $page, CategoryRepository $category, SettingRepository $setting, ImageRepository $image) {

        $this->model = $model;
        $this->page = $page;
        $this->category = $category;
        $this->image = $image;
        $this->setting = $setting;
        $this->countPerPageAdmin = 10;
        $this->countPerPageFrontEnd = 6;
    }

    public function getAlbomsForIndexPage() {
        return $this->model
                        ->where('visible', 1)
                        ->orderBy('rem', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->whereHas('categories', function($query) {
                            $query->where('visible', '1');
                        })
                        ->with(['categories' => function($query) {
                                $query->where('visible', '1');
                            }])
                        ->paginate($this->countPerPageFrontEnd);
    }

    public function findAlbomsByQuery($query) {
        return $this->model
                        ->where('visible', 1)
                        ->where('title', 'LIKE', '%' . $query . '%')
                        ->orderBy('created_at', 'DESC')
                        ->whereHas('categories', function($query) {
                            $query->where('visible', '1');
                        })
                        ->with(['categories' => function($query) {
                                $query->where('visible', '1');
                            }])
                        ->paginate($this->countPerPageFrontEnd);
    }

    private function getAlbomBySlug($albomSlug) {
        return $this->model
                        ->where('slug', $albomSlug)
                        ->whereHas('categories', function($query) {

                            $query->where('visible', '1');
                        })
                        ->with(['categories' => function($query) {
                                $query->where('visible', '1');
                            }])
                        ->first();
    }

    public function getAlbomById($albomId) {
        return $this->getById($albomId);
    }

    public function albomPhotosList($albomSlug, $all = 0) {

        $thisAlbom = $this->getAlbomBySlug($albomSlug);
        if (!$thisAlbom) {
            App::abort(404);
        }

        if ($all == 0) {
            $imagesList = $this->image->getImagesByAlbomId($thisAlbom->id);
        } else {
            $imagesList = $this->image->getAllImagesByAlbomId($thisAlbom->id);
            $data['limit'] = 1;
        }

        if (!$imagesList) {
            App::abort(404);
        }

        $lastCategory = $thisAlbom->categories->first();

        $categories = $this->category->getAllVisibleCategories();
        $settings = $this->setting->getAllSettings();
        $data = ['albom' => $thisAlbom,
            'images' => $imagesList,
            'categories' => $categories,
            'settings' => $settings,
            'lastCatSlug' => $lastCategory->slug,
            'categoryTitle' => $lastCategory->title,
        ];

        return $data;
    }

    public function getAlbomsPaginatedWithCategories() {
        $count = $this->countPerPageAdmin;
        $alboms = $this->model
                ->with('categories')
                ->paginate($count);
        $categories = $this->category->getAllVisibleCategories();
        return ['alboms' => $alboms, 'categories' => $categories];
    }

    public function getAllWithCats() {
        $categories = $this->category->getAllVisibleCategories();
        $alboms = $this->model
                ->with('categories')
                ->get();
        return ['alboms' => $alboms, 'categories' => $categories];
    }

    public function getAlbomsPaginated() {
        $count = $this->countPerPageAdmin;
        return $this->getAllPaginated($count);
    }

    public function pageCount() {
        return ceil($this->model->count() / $this->countPerPageAdmin);
    }

    public function delCat($catId, $albomId) {
        $albom = $this->model->findOrFail($albomId);
        return $albom->categories()->detach($catId);
    }

    public function addCat($catId, $albomId) {
        $albom = $this->model->findOrFail($albomId);
        $cat = $albom->categories()->find($catId);
        if (!$cat) {
            $albom->categories()->attach($catId);
            return true;
        } else {
            return false;
        }
    }

    public function getFilteredAlbomData($limit, $category) {
        $alboms = $this->model
                ->whereHas('categories', function($query) use ($category) {
                    if ($category != '') {
                        $query->where('id', $category);
                    }
                })
                ->take($limit)
                ->get();
        $categories = $this->category->getAllVisibleCategories();
        return ['alboms' => $alboms, 'categories' => $categories, 'limit' => $limit, 'catSel' => $category];
    }

    public function getAllVisibleAlboms() {
        return $this->getAllItemsByOneParam('visible', '1');
    }

    public function albomsCount($visible) {
        return $this->model
                        ->where('visible', $visible)
                        ->count();
    }

    public function albomsCountWithCats($visible, $category) {
        return $this->model
                        ->whereHas('categories', function($query) use ($visible, $category) {
                            if ($category != '') {
                                $query->where('id', $category);
                            }
                            $query->where('visible', $visible);
                        })
                        ->with(['categories' => function($query) use ($visible, $category) {
                                if ($category != '') {
                                    $query->where('id', $category);
                                }
                                $query->where('visible', $visible);
                            }])
                        ->count();
    }

}

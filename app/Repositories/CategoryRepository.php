<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Models\Category as CategoryModel;
use App\Repositories\PageRepository;
use App\Repositories\SettingRepository;
use Cache;
use App;

/**
 * Category Repository
 *
 * @package   Repositories
 * @author    Den
 */
class CategoryRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(CategoryModel $model, PageRepository $page, SettingRepository $setting) {

        $this->model = $model;
        $this->page = $page;
        $this->countPerPage = 10;
        $this->setting = $setting;
    }

    public function getAllCategories() {
        return $this->getAll();
    }

    private function putCategoryInCache($catId) {
        if (Cache::has('lastCat')) {
            Cache::forget('lastCat');
        }
        Cache::forever('lastCat', $catId);
    }

    public function getCategoryFromCache() {
        if (Cache::has('lastCat')) {
            return Cache::get('lastCat');
        } else {
            return false;
        }
    }

    public function getCategoryById($catId) {
        return $this->getById($catId);
    }

    public function categoryList($categorySlug, $page = 1) {
        $list = $this->model
                ->where('visible', 1)
                ->where('slug', $categorySlug)
                ->first();
        $categories = $this->getAllVisibleCategories();
        $thisCategory = $this->getFirstItemByOneParam('slug', $categorySlug);
        if (!$thisCategory) {
            App::abort(404);
        }

        $settings = $this->page->getAllSettingsCategoryPage($page, $thisCategory->id);
        $sets = $this->setting->getAllSettings();
        $this->putCategoryInCache($thisCategory->id);
        if ($list) {
            $alboms = $list->alboms()->with(['categories' => function($query) {
                            $query->where('visible', '1');
                        }])->where('visible', '1')->orderBy('id', 'ASC')->paginate(6);
            $data = ['alboms' => $alboms,
                'categories' => $categories,
                'settings' => $settings,
                'sets' => $sets,
                'categoryTitle' => $thisCategory->title
            ];
        } else {
            App::abort(404);
            $data = [];
        }

        return $data;
    }

    public function getCategoriesPaginate() {
        $count = $this->countPerPage;
        return $this->getAllPaginated($count);
    }

    public function onOffCategory($catId, $state) {
        return $this->model->where('id', '=', $catId)->update(['visible' => $state]);
    }

    public function getAllVisibleCategories() {
        return $this->getAllItemsByOneParam('visible', '1');
    }

    public function delCategoriesByIds($ids) {
        $count = 0;
        foreach ($ids as $val) {

            $id = (int) $val;
            $res = $this->deleteById($id);
            if ($res) {
                $count++;
            }
        }
        if ((count($ids) >= 1) && ($count >= 1)) {
            return true;
        } else {
            return false;
        }
    }

    public function pageCount() {
        return ceil($this->model->count() / $this->countPerPage);
    }

}

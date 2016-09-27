<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Models\Page as PageModel;

/**
 * Page Repository
 * 
 * @package   Repositories
 * @author    Den
 */
class PageRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(PageModel $model) {

        $this->model = $model;
        $this->countPerPage = 10;
    }

    public function getAllSettingsIndexPage($pageNumber) {
        return $this->model
                        ->where('visible', 1)
                        ->where('category_id', NULL)
                        ->where('page_number', $pageNumber)
                        ->first();
    }

    public function getAllSettingsCategoryPage($pageNumber, $categoryId) {
        return $this->model
                        ->where('visible', 1)
                        ->where('category_id', $categoryId)
                        ->where('page_number', $pageNumber)
                        ->first();
    }

    public function getPagesPaginatedWithCategory() {
        $count = $this->countPerPage;
        $pages = $this->model
                ->with('category')
                ->paginate($count);
        return ['pages' => $pages];
    }

    public function getLastPageNumForCat($catId) {
        return $this->model
                        ->where('category_id', $catId)
                        ->where('visible', '1')
                        ->max('page_number');
    }

    public function changePageCategory($catId, $pageId) {
        return $this->model->where('id', '=', $pageId)->update(['category_id' => $catId]);
    }

    public function pageCount() {
        return ceil($this->model->count() / $this->countPerPage);
    }

    public function getFilteredPageData($limit, $category) {

        if ($category == 0) {
            $category = NULL;
        }

        $pages = $this->model
                ->where('category_id', $category)
                ->take($limit)
                ->get();
        return ['pages' => $pages, 'limit' => $limit, 'catSel' => $category];
    }

}

<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use App\Repositories\PageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\AlbomRepository;
use Input;
use Illuminate\Support\Str;

/**
 * Admin Page Repository
 * 
 * Repository for custom methods of Admin Page model
 * 
 * @package   Repositories
 * @author    Den
 */
class AdminPageRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, PageRepository $page, AlbomRepository $albom, CategoryRepository $category) {

        $this->model = $model;
        $this->page = $page;
        $this->category = $category;
        $this->albom = $albom;
        $this->countPerPageOnFrontend = 6;
    }

    public function sitePages() {
        $this->generateNewPages();
        $data = $this->page->getPagesPaginatedWithCategory();
        $categories = $this->category->getAllVisibleCategories();
        $data['categories'] = $categories;
        return $data;
    }

    public function generateNewPages() {

        $allVisibleAlbomsCount = $this->albom->albomsCount($visible = '1');
        $pagesWithNullCategoryCount = ceil($allVisibleAlbomsCount / $this->countPerPageOnFrontend);
        $lastPageNumForNullCat = $this->page->getLastPageNumForCat($catId = NULL);

        if ($lastPageNumForNullCat < $pagesWithNullCategoryCount) {
            for ($i = $lastPageNumForNullCat; $i < $pagesWithNullCategoryCount; $i++) {
                $this->generatePage($catId = NULL, $pageNum = $i + 1, $title = str_random(20));
            }
        }

        $categories = $this->category->getAllVisibleCategories();
        foreach ($categories as $category) {
            $catId = $category->id;
            $allVisibleAlbomsCountWithCats = $this->albom->albomsCountWithCats($visible = 1, $catId);
            $pagesWithCatsCount = ceil($allVisibleAlbomsCountWithCats / $this->countPerPageOnFrontend);
            $lastPageNumForCat = $this->page->getLastPageNumForCat($catId);

            if ($lastPageNumForCat < $pagesWithCatsCount) {
                for ($i = $lastPageNumForCat; $i < $pagesWithCatsCount; $i++) {
                    $this->generatePage($catId, $pageNum = $i + 1, $title = str_random(20));
                }
            }
        }
    }

    private function generatePage($catId, $pageNum, $title) {
        $data = ['category_id' => $catId,
            'page_number' => $pageNum,
            'title' => $title,
            'visible' => '1'
        ];
        $this->page->save($data);
    }

    public function changeVisibleMany() {
        $input = array_except(Input::all(), ['_token']);
        $ids = explode(',', $input['ids']);
        $status = (int) $input['visible'];
        $res = $this->page->visibleByIds($ids, $status);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Page(s) visible change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Page(s) visible change error!'];
        }
        return $data;
    }

    public function changePageCategory() {
        $input = array_except(Input::all(), ['_token']);
        $catId = (int) $input['catId'];
        $pageId = (int) $input['pageId'];
        if ($catId == 0) {
            $catId = NULL;
        }

        $res = $this->page->changePageCategory($catId, $pageId);

        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Page category change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Page category change error!'];
        }
        return $data;
    }

    public function delPages() {
        $input = array_except(Input::all(), ['_token']);
        $page = (int) $input['page'];
        $ids = explode(',', $input['hashes']);
        $ret = $this->page->delByIds($ids);
        if ($ret) {
            if ($page > $this->page->pageCount()) {
                $page = $this->page->pageCount();
            }
            return ['message' => 'Pages was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Pages deleted'];
        }
    }

    public function deletePage($id) {
        $ret = $this->page->deleteById($id);
        $page = Input::get('page');
        if ($ret) {
            if ($page > $this->page->pageCount()) {
                $page = $this->page->pageCount();
            }
            return ['message' => 'Page was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Page deleted'];
        }
    }

    public function allPages() {
        $pages = $this->page->getAll();
        $categories = $this->category->getAllVisibleCategories();
        return ['pages' => $pages, 'all' => 'all', 'categories' => $categories];
    }

    public function filter() {
        $input = array_except(Input::all(), ['_token']);
        $limit = (int) $input['limit'];
        $catSel = (int) $input['catSel'];
        $data = $this->page->getFilteredPageData($limit, $catSel);
        $categories = $this->category->getAllVisibleCategories();
        $data['categories'] = $categories;
        return $data;
    }

    public function editPage($pageId) {
        $page = $this->page->getById($pageId);
        $categories = $this->category->getAllVisibleCategories();
        return ['page' => $page, 'categories' => $categories];
    }

    public function updatePage($id, $request) {
        $page = Input::get('page');
        $input = array_except(Input::all(), ['_token', 'page', '_method', 'category_id']);

        if ($input['visible'] == '') {
            $input['visible'] = 1;
        }

        if ($input['description'] != '') {
            $input['description'] = strip_tags($input['description']);
        } elseif (($input['description'] == '') && ($input['content'] != '')) {
            $input['description'] = Str::words(strip_tags($input['content']), 10);
        } elseif (($input['description'] == '') && ($input['content'] == '') && ($input['title'] != '')) {
            $input['description'] = strip_tags($input['title']);
        }

        if ($input['keywords'] == '') {

            $expl_keywords = explode(' ', $input['title']);

            if (isset($expl_keywords[1])) {

                $keywords_string = '';
                foreach ($expl_keywords as $key => $value) {
                    $st = preg_replace("/[^a-zA-ZА-Яа-яёЁ0-9\s]/u", "", $value);
                    if ($st != '')
                        $keywords_string = $keywords_string . Str::lower($st) . ', ';
                }

                $keywords_string = substr($keywords_string, 0, -2);
            } else {
                $keywords_string = Str::lower($expl_keywords[0]);
            }

            $input['keywords'] = $keywords_string;
        }

        if ($input['content'] == '') {
            $input['content'] = $input['title'];
        }

        $ret = $this->page->updateById($id, $input);
        if ($ret) {
            return ['message' => 'Page was updated', 'page' => $page];
        } else {
            return ['error' => 'Error while Page updated'];
        }
    }

}

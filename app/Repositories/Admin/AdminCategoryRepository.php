<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use App\Repositories\CategoryRepository;
use Input;
use Illuminate\Support\Str;

/**
 * Admin Category Repository
 * 
 * Repository for custom methods of Admin Category model
 * 
 * @package   Repositories
 * @author    Den
 */
class AdminCategoryRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, CategoryRepository $category) {

        $this->model = $model;
        $this->category = $category;
    }

    public function siteCategories() {
        $categories = $this->category->getCategoriesPaginate();
        return ['categories' => $categories];
    }

    public function onOff() {
        $input = array_except(Input::all(), ['_token']);
        $catId = (int) $input['catId'];
        $state = (int) $input['state'];
        $res = $this->category->onOffCategory($catId, $state);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Category visible change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Category visible change error!'];
        }
        return $data;
    }

    public function delCategories() {
        $input = array_except(Input::all(), ['_token']);
        $page = (int) $input['page'];
        $ids = explode(',', $input['hashes']);
        $ret = $this->category->delCategoriesByIds($ids);
        if ($ret) {
            if ($page > $this->category->pageCount()) {
                $page = $this->category->pageCount();
            }
            return ['message' => 'Categories was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Categories deleted'];
        }
    }

    public function deleteCategory($id) {
        $ret = $this->category->deleteById($id);
        $page = Input::get('page');
        if ($ret) {
            if ($page > $this->category->pageCount()) {
                $page = $this->category->pageCount();
            }
            return ['message' => 'Category was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Category deleted'];
        }
    }

    public function allCategories() {
        $categories = $this->category->getAll();
        return ['categories' => $categories, 'all' => 'all'];
    }

    public function editCategory($catId) {
        $category = $this->category->getById($catId);
        return ['category' => $category];
    }

    public function updateCategory($id, $request) {
        $page = Input::get('page');
        $data = array_except(Input::all(), ['_token', '_method', 'page']);
        $data['slug'] = Str::slug($data['title']);
        $ret = $this->category->updateById($id, $data);
        if ($ret) {
            return ['message' => 'Category was updated', 'page' => $page];
        } else {
            return ['error' => 'Error while Category deleted'];
        }
    }

    public function storeNewCategory($request) {
        $input = array_except(Input::all(), ['_token', 'page']);
        $input['slug'] = Str::slug($input['title']);

        if ($input['visible'] == '') {
            $input['visible'] = 1;
        }
        if (!isset($input['description'])) {
            $input['description'] = '';
        }
        if (!isset($input['content'])) {
            $input['content'] = '';
        }
        if (!isset($input['keywords'])) {
            $input['keywords'] = '';
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

        $ret = $this->category->save($input);

        if ($ret->exists == '1') {
            return ['message' => 'Setting created', 'page' => $this->category->pageCount()];
        } else {
            return ['error' => 'Error while Setting created'];
        }
    }

}

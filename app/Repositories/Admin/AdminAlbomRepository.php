<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use App\Repositories\AlbomRepository;
use Input;
use Illuminate\Support\Str;
use URL;

/**
 * Admin Albom Repository
 *
 * Repository for custom methods of Admin Albom model
 *
 * @package   Repositories
 * @author    Den
 */
class AdminAlbomRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, AlbomRepository $albom) {

        $this->model = $model;
        $this->albom = $albom;
    }

    public function siteAlboms() {
        $data = $this->albom->getAlbomsPaginatedWithCategories();
        return $data;
    }

    public function changeVisibleMany() {
        $input = array_except(Input::all(), ['_token']);
        $ids = explode(',', $input['ids']);
        $status = (int) $input['visible'];
        $res = $this->albom->visibleByIds($ids, $status);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Albom(s) visible change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Albom(s) visible change error!'];
        }
        return $data;
    }

    public function addCat() {
        $input = array_except(Input::all(), ['_token']);
        $catId = (int) $input['catId'];
        $albomId = (int) $input['albId'];
        if ($catId == 0) {
            $data = ['status' => 'error', 'message' => 'Select Category!'];
        } else {
            $res = $this->albom->addCat($catId, $albomId);
            if ($res) {
                $data = ['status' => 'ok', 'message' => 'Category was added!'];
            } else {
                $data = ['status' => 'error', 'message' => 'Error while category added!'];
            }
        }

        return $data;
    }

    public function delCat() {
        $input = array_except(Input::all(), ['_token']);
        $catId = (int) $input['catId'];
        $albomId = (int) $input['albId'];
        $res = $this->albom->delCat($catId, $albomId);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Category delete!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Error while category delete!'];
        }
        return $data;
    }

    public function delAlboms() {
        $input = array_except(Input::all(), ['_token']);
        $page = (int) $input['page'];
        $ids = explode(',', $input['hashes']);
        $ret = $this->albom->delByIds($ids);
        if ($ret) {
            if ($page > $this->albom->pageCount()) {
                $page = $this->albom->pageCount();
            }
            return ['message' => 'Alboms was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Alboms deleted'];
        }
    }

    public function allAlboms() {
        $albomsCats = $this->albom->getAllWithCats();
        return ['alboms' => $albomsCats['alboms'], 'all' => 'all', 'categories' => $albomsCats['categories']];
    }

    public function deleteAlbom($id) {
        $ret = $this->albom->deleteById($id);
        $page = Input::get('page');
        if ($ret) {
            if ($page > $this->albom->pageCount()) {
                $page = $this->albom->pageCount();
            }
            return ['message' => 'Albom was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Albom deleted'];
        }
    }

    private function storeAlbom($input) {
        $input['slug'] = Str::slug($input['title']);

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
            // echo '!';exit;
            $expl_keywords = explode(' ', $input['description']);

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

        if (isset($input['image'])AND ( $input['image'] != '')) {

            if (Input::file('image')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = 'albom' . rand(11111, 99999) . '.' . $extension; // rename image
                Input::file('image')->move($destinationPath, $fileName);
                $input['thumb'] = asset('uploads/' . $fileName);
            }
        } else if (isset($input['image'])AND ( $input['image'] == '')) {
            $input['thumb'] = asset('css/noimage.jpg');
        } else if (!isset($input['image'])AND ( $input['thumb'] == '')) {
            $input['thumb'] = asset('css/noimage.jpg');
        }

        return $this->albom->save($input);
    }

    public function storeNewAlbomParser($input) {
        $ret = $this->storeAlbom($input);
        return $ret;
    }

    public function storeNewAlbom($request) {
        $input = array_except(Input::all(), ['_token', 'page']);
        $ret = $this->storeAlbom($input);
        if ($ret->exists == '1') {
            return ['message' => 'Albom created', 'page' => $this->albom->pageCount()];
        } else {
            return ['error' => 'Error while Albom created'];
        }
    }

    public function editAlbom($albomId) {
        $albom = $this->albom->getById($albomId);
        return ['albom' => $albom];
    }

    public function updateAlbom($id, $request) {
        $page = Input::get('page');
        $input = array_except(Input::all(), ['_token', 'page']);
        $catSel = (int) $input['catSel'];
        $limit = (int) $input['limit'];
        $input = array_except(Input::all(), ['_token', 'page', 'catSel', 'limit']);
        $input['slug'] = Str::slug($input['title']);

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

            $expl_keywords = explode(' ', $input['description']);

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
        if (isset($input['image'])AND ( $input['image'] != '')) {
            if (Input::file('image')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // get image extension
                $fileName = 'albom' . rand(11111, 99999) . '.' . $extension; // renam image
                Input::file('image')->move($destinationPath, $fileName);
                $input['thumb'] = asset('uploads/' . $fileName);
            }
        } else if (isset($input['file'])AND ( $input['file'] == '')) {
            $input['thumb'] = asset('css/noimage.jpg');
        } else if (!isset($input['file'])AND ( $input['thumb'] == '')) {
            $input['thumb'] = asset('css/noimage.jpg');
        }
        $data = array_except($input, ['image', '_method']);
        $ret = $this->albom->updateById($id, $data);

        $url = URL::previous();
        $urlParts = explode('/admin/alboms/filter', $url);
        $filterFlag = false;
        if (isset($urlParts[1])) {
            $filterFlag = true;
        }

        if ($ret) {
            return ['message' => 'Albom was updated', 'page' => $page, 'catSel' => $catSel, 'filterFlag' => $filterFlag, 'limit' => $limit];
        } else {
            return ['error' => 'Error while Albom updated'];
        }
    }

    public function filter() {
        $input = array_except(Input::all(), ['_token']);
        $limit = (int) $input['limit'];
        $catSel = (int) $input['catSel'];
        $data = $this->albom->getFilteredAlbomData($limit, $catSel);
        return $data;
    }

}

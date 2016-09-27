<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use App\Repositories\ImageRepository;
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
class AdminImageRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, ImageRepository $image, AlbomRepository $albom) {

        $this->model = $model;
        $this->image = $image;
        $this->albom = $albom;
    }

    public function siteImages() {
        $images = $this->image->getImagesPaginated();
        $alboms = $this->albom->getAllVisibleAlboms();
        return ['images' => $images, 'alboms' => $alboms];
    }

    public function getAlboms() {
        return $this->albom->getAllVisibleAlboms();
    }

    public function changeVisibleMany() {
        $input = array_except(Input::all(), ['_token']);
        $ids = explode(',', $input['ids']);
        $status = (int) $input['visible'];
        $res = $this->image->visibleByIds($ids, $status);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Image(s) visible change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Image(s) visible change error!'];
        }
        return $data;
    }

    public function delImages() {
        $input = array_except(Input::all(), ['_token']);
        $albSel = (int) $input['albSel'];
        $page = (int) $input['page'];
        $ids = explode(',', $input['hashes']);

        $url = URL::previous();
        $urlParts = explode('/admin/images/filter', $url);
        $filterFlag = false;
        if (isset($urlParts[1])) {
            $filterFlag = true;
        }

        $ret = $this->image->delByIds($ids);
        if ($ret) {
            if ($page > $this->image->pageCount()) {
                $page = $this->image->pageCount();
            }
            return ['message' => 'Images was deleted', 'page' => $page, 'albSel' => $albSel, 'filterFlag' => $filterFlag];
        } else {
            return ['error' => 'Error while Images deleted', 'page' => $page, 'albSel' => $albSel];
        }
    }

    public function deleteImage($id) {
        $ret = $this->image->deleteById($id);
        $page = Input::get('page');
        $input = array_except(Input::all(), ['_token']);
        $albSel = (int) $input['albSel'];

        $url = URL::previous();
        $urlParts = explode('/admin/images/filter', $url);
        $filterFlag = false;
        if (isset($urlParts[1])) {
            $filterFlag = true;
        }

        if ($ret) {
            if ($page > $this->image->pageCount()) {
                $page = $this->image->pageCount();
            }
            return ['message' => 'Image was deleted', 'page' => $page, 'albSel' => $albSel, 'filterFlag' => $filterFlag];
        } else {
            return ['error' => 'Error while Image deleted'];
        }
    }

    public function allImages() {
        $images = $this->image->getAll();
        $alboms = $this->albom->getAllVisibleAlboms();
        return ['images' => $images, 'alboms' => $alboms, 'all' => 'all'];
    }

    public function changeImageAlbom() {
        $input = array_except(Input::all(), ['_token']);
        $albomId = (int) $input['albomId'];
        $imageId = (int) $input['imageId'];
        $res = $this->image->changeImageAlbom($albomId, $imageId);
        if ($res) {
            $data = ['status' => 'ok', 'message' => 'Image albom change success!'];
        } else {
            $data = ['status' => 'error', 'message' => 'Image albom change error!'];
        }
        return $data;
    }

    public function filter() {
        $input = array_except(Input::all(), ['_token']);
        if (isset($input['page'])) {
            $page = (int) $input['page'];
        } else {
            $page = 1;
        }
        if (isset($input['limit'])) {
            $limit = (int) $input['limit'];
        } else {

            $limit = 100;
        }
        $offset = ($page - 1) * $limit;
        if (isset($input['sort']) && ($input['sort']) == 'on') {

            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        if (isset($input['albSel'])) {
            $albSel = (int) $input['albSel'];
        } else {
            $albSel = 0;
        }
        $data = $this->image->getFilteredImageData($limit, $albSel, $sort, $offset);
        $alboms = $this->albom->getAllVisibleAlboms();
        $data['alboms'] = $alboms;
        $data['albomSel'] = $albSel;
        return $data;
    }

    public function editImage($imgId) {
        $image = $this->image->getById($imgId);
        $alboms = $this->albom->getAllVisibleAlboms();
        return ['image' => $image, 'alboms' => $alboms];
    }

    public function prepareForEditImage($input) {
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
            $input['content'] = $input['description'];
        }

        if ($input['notes'] == '') {
            $input['notes'] = $input['title'];
        }

        if ($input['alt_text'] == '') {
            $input['alt_text'] = $input['title'];
        }

        if ($input['caption'] == '') {
            $input['caption'] = $input['title'];
        }
        return $input;
    }

    public function updateImageMeta($id, $inp) {
        $input = $this->prepareForEditImage($inp);
        $r = $this->image->checkImageExistBySlug($input['slug']);
        $ret = false;
        if (!$r) {
            $ret = $this->image->updateById($id, $input);
        }
        if ($ret) {
            return true;
        } else {
            return false;
        }
    }

    public function updateImage($id, $request) {
        $page = Input::get('page');

        $input = array_except(Input::all(), ['_token', 'page', '_method']);
        $albSel = (int) $input['albSel'];
        $input = array_except(Input::all(), ['_token', 'page', '_method', 'albSel']);
        $input = $this->prepareForEditImage($input);

        $url = URL::previous();
        $urlParts = explode('/admin/images/filter', $url);
        $filterFlag = false;
        if (isset($urlParts[1])) {
            $filterFlag = true;
        }
        $alboms = $this->albom->getAllVisibleAlboms();
        $images = $this->image->getImagesPaginated();
        $ret = $this->image->updateById($id, $input);
        if ($ret) {
            return ['message' => 'Image was updated', 'page' => $page, 'images' => $images, 'albSel' => $albSel, 'filterFlag' => $filterFlag, 'alboms' => $alboms, 'sort' => 'on'];
        } else {
            return ['error' => 'Error while Image updated'];
        }
    }

    public function storeNewImage($request) {
        $input = array_except(Input::all(), ['_token', 'page']);
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
            $input['content'] = $input['description'];
        }

        if ($input['notes'] == '') {
            $input['notes'] = $input['title'];
        }

        if ($input['alt_text'] == '') {
            $input['alt_text'] = $input['title'];
        }

        if ($input['caption'] == '') {
            $input['caption'] = $input['title'];
        }


        $ret = $this->image->save($input);

        if ($ret->exists == '1') {
            return ['message' => 'Image created', 'page' => $this->image->pageCount()];
        } else {
            return ['error' => 'Error while Image created'];
        }
    }

}

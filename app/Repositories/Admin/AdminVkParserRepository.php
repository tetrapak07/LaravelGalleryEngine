<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use Input;
use App\Repositories\AlbomRepository;
use App\Repositories\Admin\AdminVkApiRepository;
use App\Repositories\Admin\AdminAlbomRepository;
use Illuminate\Support\Str;
use App\Repositories\ImageRepository;
use App\Repositories\CategoryRepository;

/**
 * Admin Vk Parser Repository
 * 
 * 
 * @package   Repositories
 * @author    Den
 */
class AdminVkParserRepository extends EloquentRepository {

    private $apiKey = '';
    private $appId = '';
    private $login = '';
    private $password = '';
    private $authRedirectUrl = 'http://api.vk.com/blank.html';

    public function __construct(AlbomRepository $albom, ImageRepository $image, CategoryRepository $category, AdminAlbomRepository $albomAdmin) {
        $this->albom = $albom;
        $this->image = $image;
        $this->category = $category;
        $this->albomAdmin = $albomAdmin;
    }

    public function vkParserData() {
        $alboms = $this->albom->getAllVisibleAlboms();
        $data['alboms'] = $alboms;
        $categories = $this->category->getAllVisibleCategories();
        $data['categories'] = $categories;
        return $data;
    }

    public function addNewImages() {
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        $alboms = $this->albom->getAllVisibleAlboms();
        $categories = $this->category->getAllVisibleCategories();
        $input = array_except(Input::all(), ['_token']);
        $vkPublicId = (int) $input['public_id'];
        $vkAlbomId = trim($input['albom_id']);
        $vkCount = (int) $input['count'];
        $vkOffset = (int) $input['offset'];
        $thisSiteAlbom = (int) $input['albom'];

        if ($vkCount > 1000) {
            $vkCount = 1000;
        }
        if ($vkOffset < 0) {
            $vkOffset = 0;
        }

        $this->vkParser = new AdminVkApiRepository(array(
            'apiKey' => $this->apiKey,
            'appId' => $this->appId,
            'login' => $this->login,
            'password' => $this->password,
            'authRedirectUrl' => $this->authRedirectUrl
        ));

        if ((isset($input['all_alboms']))AND ( isset($input['cat']))AND ( $input['all_alboms'] == '1')AND ( $input['cat'] != '')) {
            $albomsFromVk = $this->vkParser->getAlboms($vkPublicId);
            if (isset($albomsFromVk['error_msg'])) {

                return ['status' => 'error', 'error_message' => $albomsFromVk['error_msg'], 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
            } else if (count($albomsFromVk) == 0) {
                return ['status' => 'error', 'error_message' => 'No Alboms!', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
            } else if (count($albomsFromVk) > 0) {

                $countAlboms = 0;
                foreach ($albomsFromVk as $vkAlbom) {
                    $vkAlbomId = $vkAlbom['aid'];
                    $data1['title'] = $vkAlbom['title'];
                    $data1['description'] = $vkAlbom['description'];
                    $data1['content'] = '';
                    $data1['keywords'] = '';
                    $data1['visible'] = '1';

                    if (isset($vkAlbom['sizes']['1']['src'])AND ( isset($vkAlbom['sizes']['0']['src']))) {
                        $data1['thumb'] = $vkAlbom['sizes']['1']['src'];
                        if ($data1['thumb'] == '') {
                            $data1['thumb'] = $vkAlbom['sizes']['0']['src'];
                        }
                    }
                    $ret = $this->albomAdmin->storeNewAlbomParser($data1);
                    $albId = $ret->id;
                    $albom = $this->albom->getAlbomById($albId);
                    $albom->categories()->attach($input['cat']);

                    $imagesFromVk = $this->vkParser->photosGet($vkPublicId, $vkAlbomId, '1', '1', $vkOffset, $vkCount);

                    if (isset($imagesFromVk['error_msg'])) {
                        
                    } else if (count($imagesFromVk) == 0) {
                        
                    } else if (count($imagesFromVk) > 0) {

                        $count = 0;
                        foreach ($imagesFromVk as $vkImage) {
                            if (isset($vkImage['width'])AND ( $vkImage['height'])) {
                                $data['width'] = (int) $vkImage['width'];
                                $data['height'] = (int) $vkImage['height'];
                            }
                            $data['ext'] = 'jpg';
                            $data['file_type'] = 'image/jpeg';
                            $data['file_size'] = '';
                            $data['url_thumb'] = $vkImage['src'];
                            if (isset($vkImage['src_xxbig'])) {
                                $data['url'] = $vkImage['src_xxbig'];
                            } else if (isset($vkImage['src_xbig'])) {
                                $data['url'] = $vkImage['src_xbig'];
                            } else if ((isset($vkImage['src_big']))) {
                                $data['url'] = $vkImage['src_big'];
                            }

                            $data['title'] = str_random(20);

                            $data['slug'] = Str::slug($data['title']);
                            $data['albom_id'] = $albId;

                            $check = $this->image->checkIsSetImageByImage($data['url']);
                            if (!$check) {
                                $this->image->save($data);
                                $count++;
                            }
                        }
                    }

                    $countAlboms++;
                }
            }
            return ['message' => $countAlboms . ' Alboms created', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
        }

        $imagesFromVk = $this->vkParser->photosGet($vkPublicId, $vkAlbomId, '1', '1', $vkOffset, $vkCount);

        if (isset($imagesFromVk['error_msg'])) {

            return ['status' => 'error', 'error_message' => $imagesFromVk['error_msg'], 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
        } else if (count($imagesFromVk) == 0) {
            return ['status' => 'error', 'error_message' => 'No Images!', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
        } else if (count($imagesFromVk) > 0) {

            $count = 0;
            foreach ($imagesFromVk as $vkImage) {
                if (isset($vkImage['width'])AND ( $vkImage['height'])) {
                    $data['width'] = (int) $vkImage['width'];
                    $data['height'] = (int) $vkImage['height'];
                }
                $data['ext'] = 'jpg';
                $data['file_type'] = 'image/jpeg';
                $data['file_size'] = '';
                $data['url_thumb'] = $vkImage['src'];
                if (isset($vkImage['src_xxbig'])) {
                    $data['url'] = $vkImage['src_xxbig'];
                } else if (isset($vkImage['src_xbig'])) {
                    $data['url'] = $vkImage['src_xbig'];
                } else if ((isset($vkImage['src_big']))) {
                    $data['url'] = $vkImage['src_big'];
                }

                $data['title'] = str_random(20);

                $data['slug'] = Str::slug($data['title']);
                $data['albom_id'] = $thisSiteAlbom;
                $check = $this->image->checkIsSetImageByImage($data['url']);
                if (!$check) {
                    $this->image->save($data);
                    $count++;
                }
            }
            return ['message' => $count . ' Images created', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
        } else {
            return ['error_message' => 'Some Error', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
        }
        return ['error_message' => 'Some Error', 'inpt' => $input, 'alboms' => $alboms, 'categories' => $categories];
    }

}

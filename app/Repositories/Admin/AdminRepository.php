<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use AdminAuth;
use Hash;
use App\Repositories\SettingRepository;
use App\Repositories\Admin\AdminPageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\AlbomRepository;
use App\Repositories\ImageRepository;
use App;
use URL;

/**
 * Admin Repository
 * 
 * Repository for custom methods of Admin model
 * 
 * @package   Repositories
 * @author    Den
 */
class AdminRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, SettingRepository $setting, CategoryRepository $category, AlbomRepository $albom, ImageRepository $image, AdminPageRepository $pageAdm) {

        $this->model = $model;
        $this->setting = $setting;
        $this->category = $category;
        $this->albom = $albom;
        $this->image = $image;
        $this->pageAdm = $pageAdm;
    }

    /**
     * Change Admin Password
     *
     * @param AdminRequest $request change password post data
     * @return array
     */
    public function changePassword($request) {
        $input = \Request::all();
        $adminId = AdminAuth::user()->id;
        $admin = $this->getById($adminId);
        $hashedOldPassword = $admin->password;
        $oldPassword = $input['old_password'];
        if (Hash::check($oldPassword, $hashedOldPassword)) {
            $newPassword = bcrypt($input['password']);
            $admin->password = $newPassword;
            $admin->save();
            return ['message' => 'Your Password has been updated.'];
        } else {
            return ['error' => 'Old password does not match'];
        }
    }

    public function generateNewPages() {
        $this->pageAdm->generateNewPages();
    }

    public function sitemapGen() {
        $sitemap = App::make("sitemap");
        $timestamp = date('c', time());

        $sitemap->add(URL::to('/'), $timestamp, '1.0', 'daily');

        $categories = $this->category->getAllVisibleCategories();
        foreach ($categories as $category) {
            $sitemap->add(URL::to('/') . '/category/' . $category->slug, $timestamp, '0.85', 'weekly');
        }

        $alboms = $this->albom->getAllVisibleAlboms();
        foreach ($alboms as $albom) {
            $sitemap->add(URL::to('/') . '/albom/' . $albom->slug, $timestamp, '0.9', 'daily');
        }

        $images = $this->image->getAllVisibleImages();
        foreach ($images as $image) {
            $sitemap->add(URL::to('/') . '/image/' . $image->slug, $timestamp, '0.95', 'daily');
        }

        $sitemap->store('xml', 'sitemap');
        return ['message' => 'Your Sitemap was generated.'];
    }

}

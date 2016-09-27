<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\AlbomRepository;
use App\Repositories\SettingRepository;

/**
 * Search Repository
 * 
 * @package   Repositories
 * @author    Den
 */
class SearchRepository extends EloquentRepository {

    public function __construct(
    CategoryRepository $category, SettingRepository $setting, AlbomRepository $albom) {

        $this->category = $category;
        $this->albom = $albom;
        $this->setting = $setting;
    }

    public function startPage() {
        $categories = $this->category->getAllVisibleCategories();
        return ['categories' => $categories];
    }

    public function searchResult($query) {
        $alboms = $this->albom->findAlbomsByQuery($query);
        $categories = $this->category->getAllVisibleCategories();
        $settings = $this->setting->getAllSettings();
        return ['categories' => $categories,
            'alboms' => $alboms,
            'settings' => $settings,
            'query' => $query];
    }

}

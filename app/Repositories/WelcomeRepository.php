<?php namespace App\Repositories;

use App\Core\EloquentRepository;
use App\Repositories\AlbomRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SettingRepository;
use App\Repositories\PageRepository;
use Cache;

/**
 * Welcome Repository
 * 
 * Repository for custom methods of index Page
 * 
 * @package   Repositories
 * @author    Den
 */
class WelcomeRepository extends EloquentRepository {

    /**
     *
     * @var albom
     */
    protected $albom;

    /**
     *
     * @var page
     */
    protected $page;

    /**
     *
     * @var category
     */
    protected $category;

    /**
     *
     * @var setting
     */
    protected $setting;

    public function __construct(AlbomRepository $albom, PageRepository $page, SettingRepository $setting, CategoryRepository $category) {

        $this->albom = $albom;
        $this->page = $page;
        $this->setting = $setting;
        $this->category = $category;
    }

    public function getDataForIndexPage($page) {

        $categories = Cache::remember('categories', 60, function() {
                    return $this->category->getAllVisibleCategories();
                });

        $alboms = $this->albom->getAlbomsForIndexPage();

        if ($page == 1) {
            $settings = $this->setting->getAllSettings();
            $sets = $settings;
        } elseif ($page > 1) {
            $settings = $this->page->getAllSettingsIndexPage($page);
            $sets = $this->setting->getAllSettings();
        }

        $lastCategoryId = $this->category->getCategoryFromCache();

        if ($lastCategoryId) {
            $lastCategory = $this->category->getCategoryById($lastCategoryId);
        }

        $data = ['alboms' => $alboms,
            'categories' => $categories,
            'categoryTitle' => $sets->main_page_h2,
            'settings' => $settings,
            'sets' => $sets
        ];

        return $data;
    }

}

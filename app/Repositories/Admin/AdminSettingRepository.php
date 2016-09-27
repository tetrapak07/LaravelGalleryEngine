<?php namespace App\Repositories\Admin;

use App\Core\EloquentRepository;
use App\Models\Admin as AdminModel;
use App\Repositories\SettingRepository;
use Input;

/**
 * Admin Setting Repository
 * 
 * Repository for custom methods of Admin Setting model
 * 
 * @package   Repositories
 * @author    Den
 */
class AdminSettingRepository extends EloquentRepository {

    /**
     *
     * @var model
     */
    protected $model;

    public function __construct(AdminModel $model, SettingRepository $setting) {

        $this->model = $model;
        $this->setting = $setting;
    }

    public function siteSettings() {
        $settings = $this->setting->getSettingsPaginate();
        return ['settings' => $settings];
    }

    public function editSettings($settingId) {
        $setting = $this->setting->getSettingById($settingId);
        return ['setting' => $setting];
    }

    public function storeNewSetting($request) {
        $input = array_except(Input::all(), ['_token', 'page']);
        $ret = $this->setting->save($input);

        if ($ret->exists == '1') {
            return ['message' => 'Setting created', 'page' => $this->setting->pageCount()];
        } else {
            return ['error' => 'Error while Setting created'];
        }
    }

    public function deleteSetting($id) {
        $ret = $this->setting->deleteById($id);
        $page = Input::get('page');
        if ($ret) {
            if ($page > $this->setting->pageCount()) {
                $page = $this->setting->pageCount();
            }
            return ['message' => 'Setting was deleted', 'page' => $page];
        } else {
            return ['error' => 'Error while Setting deleted'];
        }
    }

    public function updateSetting($id, $request) {
        $page = Input::get('page');
        $data = array_except(Input::all(), ['_token', '_method', 'page']);
        $ret = $this->setting->updateById($id, $data);
        if ($ret) {
            return ['message' => 'Setting was updated', 'page' => $page];
        } else {
            return ['error' => 'Error while Setting deleted'];
        }
    }

    public function allSetting() {
        $settings = $this->setting->getAll();
        return ['settings' => $settings, 'all' => 'all'];
    }

}

<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminSettingRepository;
use Admin;
use App\Models\Setting;
use App\Http\Requests\Admin\AdminSettingRequest;
use Redirect;

/**
 * Admin Settings Controller (Work with main site settings)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AdminSettingController extends Controller {

    /**
     * Admin Repository
     *
     * @var App\Repositories\Admin\AdminRepository
     */
    protected $adminSetting;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminSettingRepository $adminSetting) {
        $this->middleware('authOwl');
        $this->adminSetting = $adminSetting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $data = $this->adminSetting->siteSettings();
        $content = view('admin.settings.index', $data)->render();
        $title = 'Admin - Settings';
        return Admin::view($content, $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Setting $setting) {
        return view('admin.settings.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminSettingRequest $request) {

        $data = $this->adminSetting->storeNewSetting($request);
        if (isset($data['message'])) {
            return Redirect::to('admin/settings?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.settings.index')->with('error', $data['error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $data = $this->adminSetting->editSettings($id);
        return view('admin.settings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, AdminSettingRequest $request) {
        $data = $this->adminSetting->updateSetting($id, $request);
        if (isset($data['message'])) {
            return Redirect::to('admin/settings?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.settings.index')->with('error', $data['error']);
        }
    }

    /**
     * Show the form for deleting the specified resource.
     * 
     * @param int $id
     * @return Response
     */
    public function del($id) {
        return view('admin.settings.del', compact('id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = $this->adminSetting->deleteSetting($id);
        if (isset($data['message'])) {
            return Redirect::to('admin/settings?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.settings.index')->with('error', $data['error']);
        }
    }

    public function all() {
        $data = $this->adminSetting->allSetting();
        $content = view('admin.settings.index', $data)->render();
        $title = 'Admin - Settings';
        return Admin::view($content, $title);
    }

}

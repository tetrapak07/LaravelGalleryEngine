<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminPageRepository;
use Admin;
use App\Http\Requests\Admin\AdminPageRequest;
use Redirect;


/**
 * Admin Page Controller (Page meta and content)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AdminPageController extends Controller {

    /**
     * Admin Page Repository
     *
     * @var App\Repositories\Admin\AdminPageRepository
     */
    protected $adminPage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminPageRepository $adminPage) {
        $this->middleware('authOwl');
        $this->adminPage = $adminPage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->adminPage->sitePages();
        $content = view('admin.pages.index', $data)->render();
        $title = 'Admin - Pages';
        return Admin::view($content, $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminPageRequest $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $data = $this->adminPage->editPage($id);
        return view('admin.pages.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, AdminPageRequest $request) {
        $data = $this->adminPage->updatePage($id, $request);
        if (isset($data['message'])) {
            return Redirect::to('admin/pages?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.pages.index')->with('error', $data['error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = $this->adminPage->deletePage($id);
        if (isset($data['message'])) {
            return Redirect::to('admin/pages?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.pages.index')->with('error', $data['error']);
        }
    }

    public function changeVisibleMany() {
        $data = $this->adminPage->changeVisibleMany();
        return response()->json($data);
    }

    public function changePageCategory() {
        $data = $this->adminPage->changePageCategory();
        return response()->json($data);
    }

    public function delMany() {
        $data = $this->adminPage->delPages();
        if (isset($data['message'])) {
            return Redirect::to('admin/pages?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.pages.index')->with('error', $data['error']);
        }
    }

    /**
     * Show the form for deleting the specified resource.
     * 
     * @param int $id
     * @return Response
     */
    public function del($id) {
        return view('admin.pages.del', compact('id'));
    }

    public function all() {
        $data = $this->adminPage->allPages();
        $content = view('admin.pages.index', $data)->render();
        $title = 'Admin - Pages';
        return Admin::view($content, $title);
    }

    public function filter() {
        $data = $this->adminPage->filter();
        $content = view('admin.pages.index', $data)->render();
        $title = 'Admin - Pages';
        return Admin::view($content, $title);
    }

}

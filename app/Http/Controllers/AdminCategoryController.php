<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminCategoryRepository;
use Admin;
use App\Models\Category;
use App\Http\Requests\Admin\AdminCategoryRequest;
use Redirect;

/**
 * Admin Category Controller
 * 
 * 
 * @package     Controllers
 * @author    Den
 */
class AdminCategoryController extends Controller {

    /**
     * Admin Category Repository
     *
     * @var App\Repositories\Admin\AdminCategoryRepository
     */
    protected $adminCategory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminCategoryRepository $adminCategory) {
        $this->middleware('authOwl');
        $this->adminCategory = $adminCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->adminCategory->siteCategories();
        $content = view('admin.categories.index', $data)->render();
        $title = 'Admin - Categories';
        return Admin::view($content, $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Category $category) {
        return view('admin.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminCategoryRequest $request) {
        $data = $this->adminCategory->storeNewCategory($request);
        if (isset($data['message'])) {
            return Redirect::to('admin/categories?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.categories.index')->with('error', $data['error']);
        }
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
        $data = $this->adminCategory->editCategory($id);
        return view('admin.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, AdminCategoryRequest $request) {
        $data = $this->adminCategory->updateCategory($id, $request);
        if (isset($data['message'])) {
            return Redirect::to('admin/categories?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.categories.index')->with('error', $data['error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = $this->adminCategory->deleteCategory($id);
        if (isset($data['message'])) {
            return Redirect::to('admin/categories?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.categories.index')->with('error', $data['error']);
        }
    }

    public function onOff() {
        $data = $this->adminCategory->onOff();
        return response()->json($data);
    }

    public function delMany() {
        $data = $this->adminCategory->delCategories();
        if (isset($data['message'])) {
            return Redirect::to('admin/categories?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.categories.index')->with('error', $data['error']);
        }
    }

    /**
     * Show the form for deleting the specified resource.
     * 
     * @param int $id
     * @return Response
     */
    public function del($id) {
        return view('admin.categories.del', compact('id'));
    }

    public function all() {
        $data = $this->adminCategory->allCategories();
        $content = view('admin.categories.index', $data)->render();
        $title = 'Admin - Categories';
        return Admin::view($content, $title);
    }

}

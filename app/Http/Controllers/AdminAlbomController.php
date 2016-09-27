<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminAlbomRepository;
use Admin;
use App\Models\Albom;
use App\Http\Requests\Admin\AdminAlbomRequest;
use Redirect;


class AdminAlbomController extends Controller {


   /**
   * Admin Albom Repository
   *
   * @var App\Repositories\Admin\AdminAlbomRepository
   */
  protected $adminAlbom;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(AdminAlbomRepository $adminAlbom) {
    $this->middleware('authOwl');
    $this->adminAlbom = $adminAlbom;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
    $data = $this->adminAlbom->siteAlboms();
    $content = view('admin.alboms.index', $data)->render();
    $title = 'Admin - Alboms';
    return Admin::view($content, $title);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Albom $albom) {
    return view('admin.alboms.create', compact('albom'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(AdminAlbomRequest $request) {
    $data = $this->adminAlbom->storeNewAlbom($request);
    if (isset($data['message'])) {
      return Redirect::to('admin/alboms?page=' . $data['page'])->with('message', $data['message']);
    } elseif (isset($data['error'])) {
      return Redirect::route('admin.alboms.index')->with('error', $data['error']);
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
    $data = $this->adminAlbom->editAlbom($id);
    return view('admin.alboms.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, AdminAlbomRequest $request) {
    $data = $this->adminAlbom->updateAlbom($id, $request);
    if (isset($data['message'])) {
    //return Redirect::to('admin/alboms?page='.$data['page'])->with('message', $data['message']);
    if ($data['filterFlag']===false) {
       return Redirect::to('admin/alboms?page='.$data['page'])->with('message', $data['message']);
       } else{
       return Redirect::route('albomFilter', $data)->with($data);
       }
    } elseif (isset($data['error'])) {
    return Redirect::route('admin.alboms.index')->with('error', $data['error']);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $data = $this->adminAlbom->deleteAlbom($id);
    if (isset($data['message'])) {
    return Redirect::to('admin/alboms?page='.$data['page'])->with('message', $data['message']);
    } elseif (isset($data['error'])) {
    return Redirect::route('admin.alboms.index')->with('error', $data['error']);
    }
  }

 public function changeVisibleMany() {
   $data = $this->adminAlbom->changeVisibleMany();
   return response()->json($data);
 }

 public function addCat() {
   $data = $this->adminAlbom->addCat();
   return response()->json($data);
 }

  public function delCat() {
   $data = $this->adminAlbom->delCat();
   return response()->json($data);
 }

  public function delMany() {
    $data = $this->adminAlbom->delAlboms();
    if (isset($data['message'])) {
    return Redirect::to('admin/alboms?page='.$data['page'])->with('message', $data['message']);
    } elseif (isset($data['error'])) {
    return Redirect::route('admin.alboms.index')->with('error', $data['error']);
    }
  }

   public function all() {
    $data = $this->adminAlbom->allAlboms();
    $content = view('admin.alboms.index', $data)->render();
    $title = 'Admin - Alboms';
    return Admin::view($content, $title);
  }

   public function filter() {
    $data = $this->adminAlbom->filter();
    $content = view('admin.alboms.index', $data)->render();
    $title = 'Admin - Alboms';
    return Admin::view($content, $title);
  }

  /**
   * Show the form for deleting the specified resource.
   *
   * @param int $id
   * @return Response
   */
  public function del($id) {
    return view('admin.alboms.del',compact('id'));
  }

}

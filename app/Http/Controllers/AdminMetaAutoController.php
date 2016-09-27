<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminMetaAutoRepository;
use Admin;
use App\Http\Requests\Admin\AdminMetaAutoRequest;

/**
 * Admin Meta Tags Controller (Generaton meta tags)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AdminMetaAutoController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminMetaAutoRepository $adminMeta) {
        $this->middleware('authOwl');
        $this->adminMeta = $adminMeta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->adminMeta->metaStart();
        $content = view('admin.meta.index', $data)->render();
        $title = 'Admin - Meta Auto Generation';
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
    public function store(AdminMetaAutoRequest $request) {
        $data = $this->adminMeta->storeNewMeta($request);

        $content = view('admin.meta.index', $data)->render();
        $title = 'Admin - Meta Auto Generation';
        return Admin::view($content, $title);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}

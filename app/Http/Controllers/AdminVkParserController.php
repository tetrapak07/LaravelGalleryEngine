<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminVkParserRepository;
use Admin;
use App\Http\Requests\Admin\AdminVkParserRequest;

/**
 * Admin Vk Parsing Controller (Parse content from public VK groups)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AdminVkParserController extends Controller {

    /**
     * Admin Vk Parser Repository
     *
     * @var App\Repositories\Admin\AdminVkParserRepository
     */
    protected $adminVkParser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminVkParserRepository $adminVkParser) {
        $this->middleware('authOwl');
        $this->adminVkParser = $adminVkParser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->adminVkParser->vkParserData();
        $content = view('admin.vkparser.index', $data)->render();
        $title = 'Admin - Vk Parser';
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
    public function store(AdminVkParserRequest $request) {
        $data = $this->adminVkParser->addNewImages($request);
     
        $content = view('admin.vkparser.index', $data)->render();
        $title = 'Admin - Vk Parser';
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
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

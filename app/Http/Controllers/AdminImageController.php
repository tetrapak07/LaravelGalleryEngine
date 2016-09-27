<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminImageRepository;
use Admin;
use App\Models\Image;
use App\Http\Requests\Admin\AdminImageRequest;
use Redirect;

/**
 * Admin Image Controller
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AdminImageController extends Controller {

    /**
     * Admin Photo Repository
     *
     * @var App\Repositories\Admin\AdminImageRepository
     */
    protected $adminImage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminImageRepository $adminImage) {
        $this->middleware('authOwl');
        $this->adminImage = $adminImage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->adminImage->siteImages();
        $content = view('admin.images.index', $data)->render();
        $title = 'Admin - Images';
        return Admin::view($content, $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Image $image) {
        $alboms = $this->adminImage->getAlboms();
        return view('admin.images.create', compact('image', 'alboms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminImageRequest $request) {
        $data = $this->adminImage->storeNewImage($request);
        if (isset($data['message'])) {
            return Redirect::to('admin/images?page=' . $data['page'])->with('message', $data['message']);
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.images.index')->with('error', $data['error']);
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
        $data = $this->adminImage->editImage($id);
        return view('admin.images.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, AdminImageRequest $request) {
        $data = $this->adminImage->updateImage($id, $request);
        if (isset($data['message'])) {
            if ($data['filterFlag'] === false) {
                return Redirect::to('admin/images?page=' . $data['page'])->with('message', $data['message']);
            } else {
                return Redirect::route('imageFilter', $data)->with($data);
            }
        } elseif (isset($data['error'])) {
            return Redirect::route('admin.images.index')->with('error', $data['error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = $this->adminImage->deleteImage($id);
        if (isset($data['message'])) {
            if ($data['filterFlag'] === false) {
                return Redirect::to('admin/images?page=' . $data['page'])->with('message', $data['message']);
            } else {
                return Redirect::route('imageFilter', $data)->with($data);
            }
        } elseif (isset($data['error'])) {
            // return Redirect::route('admin.images.index')->with('error', $data['error']);
            return Redirect::route('imageFilter', $data)->with($data);
        }
    }

    public function changeVisibleMany() {
        $data = $this->adminImage->changeVisibleMany();
        return response()->json($data);
    }

    public function delMany() {
        $data = $this->adminImage->delImages();
        if (isset($data['message'])) {
          
            if ($data['filterFlag'] === false) {
                return Redirect::to('admin/images?page=' . $data['page'])->with('message', $data['message']);
            } else {
                return Redirect::route('imageFilter', $data)->with($data);
            }
        } elseif (isset($data['error'])) {
            return Redirect::route('imageFilter', $data)->with($data);
        }
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function del($id) {
        return view('admin.images.del', compact('id'));
    }

    public function all() {
        $data = $this->adminImage->allImages();
        $content = view('admin.images.index', $data)->render();
        $title = 'Admin - Images';
        return Admin::view($content, $title);
    }

    public function changeImageAlbom() {
        $data = $this->adminImage->changeImageAlbom();
        return response()->json($data);
    }

    public function filter() {
        $data = $this->adminImage->filter();
        $content = view('admin.images.index', $data)->render();
        $title = 'Admin - Images';
        return Admin::view($content, $title);
    }

}

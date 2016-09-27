<?php namespace App\Http\Controllers;

use App\Repositories\ImageRepository;

/**
 * ImageController (Frontend. Show one image)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */

class ImageController extends Controller {

    /**
     * Image Repository
     *
     * @var App\Repositories\ImageRepository
     */
    protected $image;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ImageRepository $image) {
        $this->middleware('guest');
        $this->image = $image;
    }

    /**
     * Show the one Image.
     *
     * @return Response
     */
    public function oneImage($imageSlug) {
        $data = $this->image->oneImage($imageSlug);
        return view('image', $data);
    }

}

<?php namespace App\Http\Controllers;

use App\Repositories\AlbomRepository;

/**
 * Albom Controller (Frontend alboms list)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class AlbomController extends Controller {

    /**
     * Albom Repository
     *
     * @var App\Repositories\AlbomRepository
     */
    protected $albom;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AlbomRepository $albom) {
        $this->middleware('guest');
        $this->albom = $albom;
    }

    /**
     * Show the list of Photos in Albom.
     *
     * @return Response
     */
    public function albomPhotosList($albomSlug) {
        $data = $this->albom->albomPhotosList($albomSlug);
        return view('albom', $data);
    }

    public function all($albomSlug) {
        $data = $this->albom->albomPhotosList($albomSlug, $all = 1);
        $data['limit'] = 1;
        return view('albom', $data);
    }

}

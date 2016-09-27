<?php namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Input;
use App;

/**
 * Category Controller (Frontend categories list)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class CategoryController extends Controller {

    /**
     * Category Repository
     *
     * @var App\Repositories\CategoryRepository
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $category) {
        $this->middleware('guest');
        $this->category = $category;
    }

    /**
     * Show the list of Categories.
     *
     * @return Response
     */
    public function categoryList($categorySlug) {

        $page = Input::get('page') ? Input::get('page') : 1;
        $data = $this->category->categoryList($categorySlug, $page);

        if (count($data) >= 1) {
            return view('welcome', $data);
        } else {
            App::abort(404);
        }
    }

}

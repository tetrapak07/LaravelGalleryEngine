<?php namespace App\Http\Controllers;

use App\Repositories\WelcomeRepository;
use Input;

class WelcomeController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Welcome Repository
     *
     * @var App\Repositories\WelcomeRepository
     */
    protected $welcome;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WelcomeRepository $welcome) {
        $this->middleware('guest');
        $this->welcome = $welcome;
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index() {

        $page = Input::get('page') ? Input::get('page') : 1;
        $data = $this->welcome->getDataForIndexPage($page);
        //print_r($data);
        return view('welcome', $data);
    }

}

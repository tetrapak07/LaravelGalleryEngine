<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\SearchRepository;

/**
 *  Search Controller (Frontend. Search functionality)
 * 
 * 
 * @package  Controllers
 * @author    Den
 */
class SearchController extends Controller {

    public function __construct(SearchRepository $search) {
        $this->middleware('guest');
        $this->search = $search;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data = $this->search->startPage();
        return view('search.index', $data);
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
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $query
     * @return Response
     */
    public function show($query) {
        $data = $this->search->searchResult($query);
        return view('search.show', $data);
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

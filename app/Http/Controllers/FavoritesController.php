<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AddPageToFavorites;
use App\Http\Requests\RemovePageFromFavorites;
use App\Page;
use Auth;
use Illuminate\Http\Request;

/**
 * Allow logged in users to view their favorite pages.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class FavoritesController extends BaseController {

    public function index(Request $request) {
        if (!$request->ajax()) {
            $this->shareData();
            return view('favorites');
        }

        // Return user favorite pages
        return response()->json(Auth::user()->favoritePages()->paginate(5));
    }

    /**
     * Add page to favorites.
     *
     * @param AddPageToFavorites $request
     */
    public function addPageToFavorites(AddPageToFavorites $request) {
        Auth::user()->favoritePages()->attach($request->input('page_id'));

        return response()->json([
            'title' => 'Success!',
            'message' => 'Page added to favorites!'
        ]);
    }

    /**
     * Remove page from favorites.
     *
     * @param  RemovePageFromFavorites $request
     */
    public function removePageFromFavorites(RemovePageFromFavorites $request) {
        Auth::user()->favoritePages()->detach($request->input('page_id'));

        return response()->json([
            'title' => 'Success!',
            'message' => 'Page removed from favorites!'
        ]);
    }

}

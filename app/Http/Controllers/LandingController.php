<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use DB;
use App\Page;

/**
 * Landing page for logged and not logged in users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LandingController extends BaseController {

    /**
     * Render landing page.
     */
    public function index(Request $request) {
        if (!$request->ajax()) {
            $this->shareData();
            return view('landing');
        }

        if (!Auth::check()) {
            return Page::paginate(5);
        }

        return Page::select('pages.*', 'users_favorite_pages.page_id')
                ->accepted()
                ->leftJoin('users_favorite_pages', function($join) {
                    $join->on('users_favorite_pages.page_id', '=', 'pages.id')
                    ->where('users_favorite_pages.user_id', Auth::user()->id);
                })->paginate(5);
    }

}

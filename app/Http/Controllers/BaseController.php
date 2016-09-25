<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use View;

/**
 * Base controller.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BaseController extends Controller {

    protected function shareData() {
        // Make user data available to all views.
        $data['loggedIn'] = false;
        if (Auth::check()) {
            $data['loggedIn'] = true;
            $data['user'] = Auth::user();
            $data['isAdmin'] = Auth::user()->hasRole('admin');
        }
        View::share('data', $data);
    }

}

<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;

/**
 * Allow admin to view registered users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UsersController extends BaseController {

    public function index() {
        return view('admin-center.users');
    }

}

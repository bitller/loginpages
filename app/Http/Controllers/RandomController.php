<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;

/**
 * Display random login page.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RandomController extends BaseController {

    public function index() {
        $this->shareData();
        return view('random');
    }

}

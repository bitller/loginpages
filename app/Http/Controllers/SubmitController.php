<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SubmitPage;
use App\Page;

/**
 * Allow user to submit pages.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubmitController extends BaseController {

    public function index() {
        $this->shareData();
        return view('submit');
    }

    public function submitPage(SubmitPage $request) {
        $page = Page::create([
            'name' => $request->input('page_name'),
            'url' => $request->input('page_url')
        ]);

        return response()->json([
            'title' => 'Great!',
            'message' => 'Log in page was sent to us. An email will be sent to you when the page will be accepted. Thank you for your contribution.'
        ]);
    }

}

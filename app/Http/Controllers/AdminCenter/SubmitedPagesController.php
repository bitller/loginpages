<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Page;

/**
 * Allow admin to manage submited pages.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubmitedPagesController extends BaseController {

    public function index(Request $request) {

        if (!$request->ajax()) {
            $this->shareData();
            return view('admin-center.submited-pages');
        }

        $response['pages'] = [
            'pending' => Page::pending()->get(),
            'declined' => Page::declined()->get(),
            'accepted' => Page::accepted()->get()
        ];

        return response()->json($response);
    }

    public function acceptPage($pageId) {
        Page::where('id', $pageId)->update(['status' => 'approved']);
        return response()->json([
            'title' => 'Success!',
            'message' => 'Page accepted and published.'
        ]);
    }

    public function declinePage($pageId) {
        Page::where('id', $pageId)->update(['status' => 'declined']);
        return response()->json([
            'title' => 'Success!',
            'message' => 'Page declined.'
        ]);
    }

}

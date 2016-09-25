<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\UploadPage;
use App\Page;
use Storage;

/**
 * Allow admin to upload pages.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UploadPageController extends BaseController {

    public function uploadPage(UploadPage $request) {

        // Store page image on s3
        $image = $request->file('page_image')->store('pages');

        $page = Page::create([
            'name' => $request->input('page_name'),
            'url' => $request->input('page_url'),
            's3_name' => $image,
            's3_url' => Storage::url($image),
            'status' => 'approved'
        ]);
    }

    public function getPage($pageId) {

        $page = Page::where('id', $pageId)->first();
        if (!$page) {
            abort(404);
            return;
        }

        return response()->json([
            'page_name' => $page->name,
            'page_url' => $page->url
        ]);
    }

}

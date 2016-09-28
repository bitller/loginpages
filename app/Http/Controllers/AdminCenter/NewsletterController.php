<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\CreateNewsletter;
use App\Http\Requests\AdminCenter\DeleteNewsletter;
use App\Newsletter;
use Illuminate\Http\Request;
use App\Page;

/**
 * Allow admin to manage the newsletter.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class NewsletterController extends BaseController {

    /**
     * Render index page or paginate newsletters if an ajax request is made.
     */
    public function index(Request $request) {
        if (!$request->ajax()) {
            $this->shareData();
            return view('admin-center.newsletter');
        }

        $newsletters = Newsletter::latest()->paginate(10);
        return response()->json([
            'newsletters' => $newsletters,
        ]);
    }

    /**
     * Return pages added since last newsletter was created.
     */
    public function getPagesSinceLastNewsletter() {
        $pages = Page::sinceLastNewsletter()->get();

        return response()->json([
            'pages' => $pages,
        ]);
    }

    /**
     * Create newsletter.
     */
    public function createNewsletter(CreateNewsletter $request) {
        $newsletter = new Newsletter();
        $newsletter->name = $request->get('newsletter_name');
        $newsletter->number = Newsletter::count();
        $newsletter->save();

        return response()->json([
            'title' => 'Success!',
            'message' => 'Newsletter created!',
        ]);
    }

    /**
     * Delete newsletter.
     */
    public function deleteNewsletter(DeleteNewsletter $request) {
        Newsletter::where('id', $request->get('newsletter_id'))->delete();
        return response()->json([
            'title' => 'Success!',
            'message' => 'Newsletter deleted!',
        ]);
    }

}

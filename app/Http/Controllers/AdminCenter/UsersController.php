<?php

namespace App\Http\Controllers\AdminCenter;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\EnableAccount;
use App\Http\Requests\AdminCenter\DisableAccount;
use Illuminate\Http\Request;
use App\User;

/**
 * Allow admin to view registered users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UsersController extends BaseController {

    /**
     * Render users index page or paginate users.
     */
    public function index(Request $request) {
        // If the request is not ajax, render the view
        if (!$request->ajax()) {
            $this->shareData();
            return view('admin-center.users');
        }

        // Else paginate users
        $users = User::with('subscription')->latest()->paginate(10);
        $registeredUsers = [
            'total' => User::count(),
            'google' => User::google()->count(),
            'facebook' => User::facebook()->count(),
            'github' => User::github()->count(),
        ];

        return response()->json([
            'users' => $users,
            'registered_users' => $registeredUsers,
        ]);
    }

    public function disableAccount(DisableAccount $request) {
        User::where('id', $request->get('user_id'))->update([
            'disabled' => true,
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Account disabled!'
        ]);
    }

    public function enableAccount(EnableAccount $request) {
        User::where('id', $request->get('user_id'))->update([
            'disabled' => false
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Account enabled!'
        ]);
    }

    public function deleteAccount() {
        //
    }

}

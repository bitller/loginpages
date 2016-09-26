<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handle data used to delete .
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAccount extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'user_id' => ['required', 'exists:users,id', 'not_admin']
        ];
    }

}

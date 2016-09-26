<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate data used to disable an account.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DisableAccount extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'user_id' => ['required', 'exists:users,id', 'not_admin']
        ];
    }
}

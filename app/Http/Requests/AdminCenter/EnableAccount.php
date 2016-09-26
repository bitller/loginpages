<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate data used to enable an account.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EnableAccount extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'user_id' => ['required', 'exists:users,id', 'not_admin']
        ];
    }

}

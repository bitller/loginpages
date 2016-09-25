<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate add page to favorites request data.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddPageToFavorites extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'page_id' => ['required', 'exists:pages,id', 'not_exists_in_user_favorites'],
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate remove page from favorites request data.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class RemovePageFromFavorites extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'page_id' => ['required', 'exists:pages,id', 'exists_in_user_favorites'],
        ];
    }

}

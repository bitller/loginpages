<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for newsletters table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Newsletter extends Model {

    public function pages() {
        return $this->belongsToMany('App\Page');
    }

}

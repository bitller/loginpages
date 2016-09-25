<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;
use Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // not_exists:table_name,column
        Validator::extend('not_exists', function($attribute, $value, $parameters, $validator) {
            if (DB::table($parameters[0])->where($parameters[1], $value)->count()) {
                return false;
            }
            return true;
        });

        Validator::extend('not_exists_in_user_favorites', function($attribute, $value, $parameters, $validator) {
            if (DB::table('users_favorite_pages')->where('user_id', Auth::user()->id)->where('page_id', $value)->count()) {
                return false;
            }
            return true;
        });

        Validator::extend('exists_in_user_favorites', function($attribute, $value, $parameters, $validator) {
            if (DB::table('users_favorite_pages')->where('user_id', Auth::user()->id)->where('page_id', $value)->count()) {
                return true;
            }
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

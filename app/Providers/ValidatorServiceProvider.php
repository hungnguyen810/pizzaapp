<?php namespace App\Providers;

use Hash;
use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the custom/extend validator services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // TODO: Add to other place to re-use
        Validator::extend('old_password', function($attribute, $value, $parameters, $validator) {
            $table = $parameters[0];
            $id = $parameters[1];
            $record = \DB::table("{$table}")->find($id);

            return Hash::check($value, $record->password);
        });

        Validator::extend('postcode_uk', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z]'.
                '[‌​0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/', $value);
        });
    }

    /**
     * Register the custom/extend validator services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

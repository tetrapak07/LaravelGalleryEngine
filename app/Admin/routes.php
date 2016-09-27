<?php

/*
 * This routes don't used
 */

Route::get('', '\App\Http\Controllers\AdminController@dashboard');


Route::get('change-pass', function ()
{
    $content = 'my page content';
    return Admin::view($content, 'My Page Title');
});

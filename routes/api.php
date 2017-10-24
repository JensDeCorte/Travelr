<?php

use Dingo\Api\Routing\Router;
use app\Api\V1\Controllers;
/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');
    }
    );


        $api->get('trip', 'App\\Api\\V1\\Controllers\\TripController@index');
        $api->get('trip/{id}', 'App\\Api\\V1\\Controllers\\TripController@show');
        $api->post('trip', 'App\\Api\\V1\\Controllers\\TripController@store');
        $api->put('trip/{id}', 'App\\Api\\V1\\Controllers\\TripController@update');
        $api->delete('trip/{id}', 'App\\Api\\V1\\Controllers\\TripController@destroy');

        $api->get('stop', 'App\\Api\\V1\\Controllers\\StopController@index');
        $api->get('stop/{id}', 'App\\Api\\V1\\Controllers\\StopController@show');
        $api->post('stop', 'App\\Api\\V1\\Controllers\\StopController@store');
        $api->put('stop/{id}', 'App\\Api\\V1\\Controllers\\StopController@update');
        $api->delete('stop/{id}', 'App\\Api\\V1\\Controllers\\StopController@destroy');

        $api->get('media', 'App\\Api\\V1\\Controllers\\MediaController@index');
        $api->get('media/{id}', 'App\\Api\\V1\\Controllers\\MediaController@show');
        $api->post('media', 'App\\Api\\V1\\Controllers\\MediaController@store');
        $api->put('media/{id}', 'App\\Api\\V1\\Controllers\\MediaController@update');
        $api->delete('media/{id}', 'App\\Api\\V1\\Controllers\\MediaController@destroy');

        $api->get('location', 'App\\Api\\V1\\Controllers\\LocationController@index');
        $api->get('location/{id}', 'App\\Api\\V1\\Controllers\\LocationController@show');
        $api->post('location', 'App\\Api\\V1\\Controllers\\LocationController@store');
        $api->put('location/{id}', 'App\\Api\\V1\\Controllers\\LocationController@update');
        $api->delete('location/{id}', 'App\\Api\\V1\\Controllers\\LocationController@destroy');

        $api->get('follower', 'App\\Api\\V1\\Controllers\\FollowerController@index');
        $api->get('follower/{id}', 'App\\Api\\V1\\Controllers\\FollowerController@show');
        $api->post('follower', 'App\\Api\\V1\\Controllers\\FollowerController@store');
        $api->put('follower/{id}', 'App\\Api\\V1\\Controllers\\FollowerController@update');
        $api->delete('follower/{id}', 'App\\Api\\V1\\Controllers\\FollowerController@destroy');

/*
    $api->group(['middleware' => 'api.auth'], function ($api) 
    {

        
        $api->post('trip', 'App\\Api\\V1\\Controllers\\TripController@store');
        $api->put('trip/{id}', 'App\\Api\\V1\\Controllers\\TripController@update');
        $api->delete('trip/{id}', 'App\\Api\\V1\\Controllers\\TripController@destroy');
    });
*/


    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});

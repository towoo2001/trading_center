<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\AccountException;

$app->get('/', function () use ($app) {
    return $app->version();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', [], function ($api) {
    $api->get('stats', function(){
    Cache::put('test_key', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0Ojg5MDMvYXBpL2F1dGgvbG9naW4xIiwiaWF0IjoxNDgwNDA4ODAxLCJleHAiOjE0ODA0MTI0MDEsIm5iZiI6MTQ4MDQwODgwMSwianRpIjoiNzhjYmFiZTNjOTc0NjBiZDZkMTE4MzYxNjA0N2Q3ZDIiLCJzdWIiOjJ9.S_mEa5FPPN_waihuY4xr4tQfGZ8ns8sdKEpuQuLpKbI', 10);
        return [
            'stats' => 'dingoapi is ok'
        ];
    });
    $api->get('stats1', function(\Illuminate\Http\Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'code' => 'required|string',
        ]);
        if ($validator->fails()) {
            throw $validator->fails();
        }
        throw new AccountException(\App\Exceptions\AccountErrMap::ERROR_PARAMETERS, 'jjjjjjjjj');
//        $test = Cache::get('test_key');
//        app('logger')->error('lllllllll');
//        return [
//            'stats' => $test,
//        ];
    });
    $api->get('stats2', function(){
        while (1) {
            sleep(5);
            Redis::publish('test-channel', json_encode(['foo'=>'bar', 'data'=>date('Y-m-d H:i:s')]));
        }
    });
    $api->post('users', function () {
        $rules = [
            'username' => ['required', 'alpha'],
            'password' => ['required', 'min:7']
        ];

        $payload = app('request')->only('username', 'password');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors(), null, [],100002);
        }
        // Create user as per usual.
    });
    $api->post('auth/login', 'App\Http\Controllers\AuthController@postLogin');
    $api->group(['middleware' => 'jwt.auth'], function($api) {
        $api->post('auth/login1', 'App\Http\Controllers\AuthController@postLogin');
    });

});
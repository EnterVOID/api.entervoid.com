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

$app->get('/', function () use ($app) {
    return $app->version();
});

// Managed files: download
$app->get('file/{id}', [
  'as' => 'getfile',
  'uses' => 'FileManagedController@get',
]);

// Managed files: upload
$app->post('file/create', [
  'as' => 'createfile',
  'uses' => 'FileManagedController@create',
]);

// Characters: get single character info
$app->get('character/{id}', [
  'as' => 'character_get_single',
  'uses' => 'CharacterController@get',
]);

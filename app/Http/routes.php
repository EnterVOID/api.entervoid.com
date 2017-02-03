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
  'uses' => 'ManagedFileController@get',
]);

// Managed files: upload
$app->post('file/create', [
  'uses' => 'ManagedFileController@create',
]);

// Characters: get character info for multiple characters
$app->get('characters', [
    'uses' => 'CharacterController@getMany',
]);

// Managed files: upload
$app->post('characters/create', [
    'uses' => 'CharacterController@create',
]);

// Characters: get character info for multiple characters
$app->get('characters/types/{id}', [
    'uses' => 'CharacterController@getType',
]);

// Characters: get character info for multiple characters
$app->get('characters/types', [
    'uses' => 'CharacterController@getTypes',
]);

// Managed files: upload
$app->post('characters/types/create', [
    'uses' => 'CharacterController@createType',
]);

// Characters: get character info for multiple characters
$app->get('characters/statuses/{id}', [
    'uses' => 'CharacterController@getStatus',
]);

// Characters: get character info for multiple characters
$app->get('characters/statuses', [
    'uses' => 'CharacterController@getStatuses',
]);

// Managed files: upload
$app->post('characters/statuses/create', [
    'uses' => 'CharacterController@createStatus',
]);

// Characters: get single character info
$app->get('characters/{id}[/{with}]', [
  'uses' => 'CharacterController@get',
]);

// Characters: update single character info
$app->put('characters/{id}', [
    'uses' => 'CharacterController@update',
]);

// Comics: get comic info for multiple comics
$app->get('comics', [
    'uses' => 'ComicController@getMany',
]);

// Comics: get single comic info
$app->get('comics/{id}', [
    'uses' => 'ComicController@get',
]);

// Comics: get single comic info
$app->post('comics/create', [
    'uses' => 'ComicController@create',
]);

// Comics: get comic info for multiple comics
$app->get('matches', [
    'uses' => 'MatchController@getMany',
]);

// Characters: get character info for multiple characters
$app->get('matches/types/{id}', [
    'uses' => 'MatchController@getType',
]);

// Characters: get character info for multiple characters
$app->get('matches/types', [
    'uses' => 'MatchController@getTypes',
]);

// Managed files: upload
$app->post('matches/types/create', [
    'uses' => 'MatchController@createType',
]);

// Characters: get character info for multiple characters
$app->get('matches/statuses/{id}', [
    'uses' => 'MatchController@getStatus',
]);

// Characters: get character info for multiple characters
$app->get('matches/statuses', [
    'uses' => 'MatchController@getStatuses',
]);

// Managed files: upload
$app->post('matches/statuses/create', [
    'uses' => 'MatchController@createStatus',
]);

// Comics: get single comic info
$app->get('matches/{id}', [
    'uses' => 'MatchController@get',
]);

// Comics: get single comic info
$app->post('matches/create', [
    'uses' => 'MatchController@create',
]);

<?php
// Characters: get character info for multiple characters
$app->get('/', [
    'uses' => 'CharacterController@getMany',
]);

// Managed files: upload
$app->post('create', [
    'uses' => 'CharacterController@create',
]);

// Characters: get character info for multiple characters
$app->get('types/{id}', [
    'uses' => 'TypeController@get',
]);

// Characters: get character info for multiple characters
$app->get('types', [
    'uses' => 'TypeController@getMany',
]);

// Managed files: upload
$app->post('types/create', [
    'uses' => 'TypeController@create',
]);

// Characters: get character info for multiple characters
$app->get('statuses/{id}', [
    'uses' => 'StatusController@get',
]);

// Characters: get character info for multiple characters
$app->get('statuses', [
    'uses' => 'StatusController@getMany',
]);

// Managed files: upload
$app->post('statuses/create', [
    'uses' => 'StatusController@create',
]);

// Characters: get single character info
$app->get('{id}[/{with}]', [
  'uses' => 'CharacterController@get',
]);

// Characters: update single character info
$app->put('{id}', [
    'uses' => 'CharacterController@update',
]);

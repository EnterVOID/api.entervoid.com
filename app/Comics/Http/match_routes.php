<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'MatchController@getMany',
]);

// Comics: standard home page
$app->get('home', [
	'uses' => 'MatchController@home',
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

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'MatchController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'MatchController@create',
]);

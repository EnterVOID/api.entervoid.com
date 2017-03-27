<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'MatchController@getMany',
]);

// Characters: get character info for multiple characters
$app->get('types/{id}', [
    'uses' => 'MatchController@getType',
]);

// Characters: get character info for multiple characters
$app->get('types', [
    'uses' => 'MatchController@getTypes',
]);

// Managed files: upload
$app->post('types/create', [
    'uses' => 'MatchController@createType',
]);

// Characters: get character info for multiple characters
$app->get('statuses/{id}', [
    'uses' => 'MatchController@getStatus',
]);

// Characters: get character info for multiple characters
$app->get('statuses', [
    'uses' => 'MatchController@getStatuses',
]);

// Managed files: upload
$app->post('statuses/create', [
    'uses' => 'MatchController@createStatus',
]);

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'MatchController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'MatchController@create',
]);

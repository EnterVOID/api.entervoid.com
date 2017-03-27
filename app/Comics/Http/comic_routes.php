<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'ComicController@getMany',
]);

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'ComicController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'ComicController@create',
]);

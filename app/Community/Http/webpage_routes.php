<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'WebpageController@getMany',
]);

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'WebpageController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'WebpageController@create',
]);

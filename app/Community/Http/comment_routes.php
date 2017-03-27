<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'CommentController@getMany',
]);

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'CommentController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'CommentController@create',
]);

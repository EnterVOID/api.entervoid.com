<?php
// Comics: get comic info for multiple comics
$app->get('/', [
    'uses' => 'ForumController@getMany',
]);

// Comics: get single comic info
$app->get('{id}', [
    'uses' => 'ForumController@get',
]);

// Comics: get single comic info
$app->post('create', [
    'uses' => 'ForumController@create',
]);

// Comics: get comic info for multiple comics
$app->get('categories', [
    'uses' => 'ForumCategoryController@getMany',
]);

// Comics: get single comic info
$app->get('categories/{id}', [
    'uses' => 'ForumCategoryController@get',
]);

// Comics: get single comic info
$app->post('categories/create', [
    'uses' => 'ForumCategoryController@create',
]);

// Comics: get comic info for multiple comics
$app->get('topics', [
    'uses' => 'ForumTopicController@getMany',
]);

// Comics: get single comic info
$app->get('topics/{id}', [
    'uses' => 'ForumTopicController@get',
]);

// Comics: get single comic info
$app->post('topics/create', [
    'uses' => 'ForumTopicController@create',
]);


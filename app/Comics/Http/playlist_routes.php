<?php
$app->get('/', [
    'uses' => 'PlaylistController@getMany',
]);

$app->get('{id}', [
    'uses' => 'PlaylistController@get',
]);

$app->post('create', [
    'uses' => 'PlaylistController@create',
]);

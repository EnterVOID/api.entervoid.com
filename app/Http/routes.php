<?php
$app->get('/', function () use ($app) {
    return $app->version();
});

// Managed files: list
$app->get('files', [
    'uses' => 'ManagedFileController@getList',
]);

// Managed files: download
$app->get('files/{id}', [
  'uses' => 'ManagedFileController@get',
]);

// Managed files: upload
$app->post('files/upload', [
  'uses' => 'ManagedFileController@upload',
]);

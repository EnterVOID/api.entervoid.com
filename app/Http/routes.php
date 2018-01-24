<?php
$app->get('/', function () use ($app) {
    return $app->version();
});

// Achievements: get list
$app->get('achievements', [
	'uses' => 'AchievementController@getMany',
]);

// Achievements: get single
$app->get('achievements/{id}', [
	'uses' => 'AchievementController@get',
]);

// Achievements: create new
$app->post('achievements/create', [
	'uses' => 'AchievementController@create',
]);

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

// Users: get user list
$app->get('users', [
	'uses' => 'UserController@getMany',
]);

// Users: get single user info
$app->get('users/{id}', [
	'uses' => 'UserController@get',
]);

// Users: create new user
$app->post('users/create', [
	'uses' => 'UsersController@create',
]);

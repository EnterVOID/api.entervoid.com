<?php
$app->get('/', [
    'uses' => 'TournamentController@getMany',
]);

$app->get('{id}', [
    'uses' => 'TournamentController@get',
]);

$app->post('create', [
    'uses' => 'TournamentController@create',
]);

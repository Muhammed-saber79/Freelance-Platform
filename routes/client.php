<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ProjectController;

Route::group([
    'prefix' => 'client',
    'as' => 'client.'
], function () {
    Route::resource('projects', ProjectController::class)
    // if i want to customize routes names:
    // ->names([
        //'index' => 'client.projects.index'
        //'create' => 'client.projects.create'
        //'store' => 'client.projects.store'
        //'show' => 'client.projects.show'
        //'edit' => 'client.projects.edit'
        //'update' => 'client.projects.update'
        //'destroy' => 'client.projects.destroy'
    //])
    ;
});
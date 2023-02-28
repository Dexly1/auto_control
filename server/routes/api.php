<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ChangeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/checkUser', [UserController::class, 'checkUser']);

Route::get('/allAutos', [AutoController::class, 'allAutos']);
Route::get('/allAutosInPlace', [AutoController::class, 'allAutosInPlace']);
Route::get('/allAutosOutPlace', [AutoController::class, 'allAutosOutPlace']);

Route::post('/addAuto', [AutoController::class, 'addAuto']);
Route::post('/updateAuto/{id}', [AutoController::class, 'updateAuto']);
Route::get('/deleteAuto/{id}', [AutoController::class, 'deleteAuto']);

Route::get('/allModels', [AutoController::class, 'allModels']);
Route::get('/allModelsByBrand/{id}', [AutoController::class, 'allModelsByBrand']);
Route::post('/addModel', [AutoController::class, 'addModel']);
Route::get('/deleteModel/{id}', [AutoController::class, 'deleteModel']);

Route::get('/allBrands', [AutoController::class, 'allBrands']);
Route::post('/addBrand', [AutoController::class, 'addBrand']);
Route::get('/deleteBrand/{id}', [AutoController::class, 'deleteBrand']);

Route::get('/allRecords', [RecordController::class, 'allRecords']);
Route::get('/getRecord/{id}', [RecordController::class, 'getRecord']);
Route::get('/deleteRecord/{id}', [RecordController::class, 'deleteRecord']);
Route::post('/editRecord', [RecordController::class, 'editRecord']);
Route::get('/allRecordTypes', [RecordController::class, 'allRecordTypes']);
Route::post('/upload', [RecordController::class, 'upload']);
Route::post('/addRecord', [RecordController::class, 'addRecord']);
Route::post('/updateRecord/{id}', [RecordController::class, 'updateRecord']);

Route::post('/accessEditIn/{id}', [RecordController::class, 'accessEditIn']);
Route::post('/accessEditOut/{id}', [RecordController::class, 'accessEditOut']);

Route::post('/addChange', [RecordController::class, 'addChange']);

Route::post('/editImage', [RecordController::class, 'editImage']);

Route::get('/allChanges', [ChangeController::class, 'allChanges']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

  //Get all contacts
  Route::get('getcontacts',  [ContactController::class, 'getContacts'] );
  //Add new contact
  Route::post('save_contact',  [ContactController::class, 'save_contact'] );
  //get contact
  Route::get('edit_contact/{id}',[ContactController::class, 'edit_contact']);
  //Update contact
  Route::post('update_contact/{id}', [ContactController::class, 'update_contact']);
  //Delete contact
  Route::delete('del_contact/{id}', [ContactController::class, 'deleteContact']);
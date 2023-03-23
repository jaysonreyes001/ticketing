<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::view("/","contents/login");
Route::view("/Login","contents/login");
Route::view("/Home","contents/home");
Route::get("/Dashboard/TicketManage/{id?}",[TicketController::class,'get_single_ticket']);





Route::get("/Testing",[TicketController::class,'display_ticket']);
Route::get("/Ticket/Delete/{id}",[TicketController::class,'delete_ticket']);


Route::post("/Auth/signin",[AuthController::class,'signin']);
Route::post("/Dashboard/TicketManage/Ticket/save_ticket",[TicketController::class,'save_ticket']);



Route::get("/Auth/Logout/{id}",[AuthController::class,'logout']);
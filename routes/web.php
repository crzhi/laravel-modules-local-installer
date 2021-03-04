<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ModulesController::class, 'index']);
//列表
Route::get('/index', [ModulesController::class, 'index'])->name('modules.index');
//详情
Route::get('/show/{name}', [ModulesController::class, 'show'])->name('modules.show');
//创建
Route::get('/create', [ModulesController::class, 'create'])->name('modules.create');
//保存
Route::post('/upload', [ModulesController::class, 'upload'])->name('modules.upload');
//启用
Route::get('/enable/{name}', [ModulesController::class, 'enable'])->name('modules.enable');
//禁用
Route::get('/disable/{name}', [ModulesController::class, 'disable'])->name('modules.disable');
//卸载
Route::get('/remove/{name}', [ModulesController::class, 'remove'])->name('modules.remove');
//安装
Route::get('/add/{name}', [ModulesController::class, 'add'])->name('modules.add');
//下载
Route::get('/download/{name}', [ModulesController::class, 'download'])->name('modules.download');

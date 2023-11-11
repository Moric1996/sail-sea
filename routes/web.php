<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestsController;
use App\Models\Post;
use App\Models\User;
use App\Models\Address;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test',  [TestsController::class, 'test']);

Route::get('/hello', function () {
    return 'こんにちは';
});

Route::get('/test', function(){
    $posts = Post::all();
    foreach($posts as $post){
        return $post->title;
    }
});

Route::get('/{id}/address', function($id){
    $user=User::find($id);
    return "ユーザー番号".$id."番の住所:".$user->address->address;
});

Route::get('/{id}/address', function($id){
    $address=Address::find($id);
    return "アドレス番号".$id."のユーザーの名前は".$address->user->name."さんです。";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

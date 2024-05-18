<?php

use App\Models\Note;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::view('notes', 'notes.index')->name('notes.index');
    Route::view('notes/create', 'notes.create')->name('notes.create');
    Volt::route('notes/{note}/edit', 'notes.edit-note')->name('notes.edit');
});
Route::get('notes/{note}', function (Note $note) {
    if (!$note->is_published) {
        abort(404);
    }
    $user = $note->user;
    return view('notes.view', compact('note', 'user'));
})->name('notes.view');

require __DIR__ . '/auth.php';

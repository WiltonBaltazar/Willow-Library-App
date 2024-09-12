<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/book/{book}/download', function (Book $book) {
    if ($book->type !== 'e-book' || !$book->file_path) {
        abort(404);
    }
    
    return response()->download(storage_path('app/' . $book->file));
})->name('book.download');
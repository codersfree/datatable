<?php

namespace App\Observers;

use App\Models\Book;

class BookObserver
{
    public function creating(Book $book)
    {
        $book->sort = Book::max('sort') + 1;
    }
}

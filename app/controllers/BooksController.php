<?php

use Core\Controller;
use App\Models\Book;

class BooksController extends Controller
{
    public function exchange()
    {
        $books = Book::getAvailable();

        $this->render('books/exchange', [
            'books' => $books
        ]);
    }
}

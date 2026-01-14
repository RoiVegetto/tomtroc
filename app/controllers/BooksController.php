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

    public function show($id)
    {
        $id = (int) $id;

        $book = Book::findById($id);

        if (!$book) {
            http_response_code(404);
            die('Livre introuvable');
        }

        $this->render('books/show', [
            'book' => $book
        ]);
    }
}

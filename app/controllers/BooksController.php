<?php

use Core\Controller;
use App\Models\Book;

class BooksController extends Controller
{
    public function exchange()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        if (!empty($search)) {
            $books = Book::search($search);
        } else {
            $books = Book::getAvailable();
        }

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

    public function edit($id)
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $id = (int) $id;
        $book = Book::findById($id);

        if (!$book) {
            http_response_code(404);
            die('Livre introuvable');
        }

        if ((int)$book['user_id'] !== (int)$_SESSION['user_id']) {
            die('Accès refusé');
        }

        $this->render('books/edit', [
            'book' => $book
        ]);
    }

    public function editPost($id)
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /tomtroc/public/auth/login');
            exit;
        }

        $id = (int) $id;
        $book = Book::findById($id);

        if (!$book) {
            http_response_code(404);
            die('Livre introuvable');
        }

        if ((int)$book['user_id'] !== (int)$_SESSION['user_id']) {
            die('Accès refusé');
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $is_available = (int)($_POST['is_available'] ?? 0);

        if ($title === '' || $author === '') {
            return $this->render('books/edit', [
                'book' => $book,
                'error' => 'Titre et auteur sont obligatoires.'
            ]);
        }

        // Gestion de l'upload de photo
        $photoPath = $book['photo']; // Garder l'ancienne par défaut
        if (!empty($_FILES['photo']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photoPath = 'uploads/' . $fileName;
            }
        }

        // Mettre à jour le livre
        Book::update($id, [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'is_available' => $is_available,
            'photo' => $photoPath
        ]);

        header('Location: /tomtroc/public/books/show/' . $id);
        exit;
    }
}

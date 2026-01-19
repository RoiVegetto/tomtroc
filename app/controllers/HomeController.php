<?php

use Core\Controller;
use App\Models\User;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        $userCount = User::countUsers();
        $latestBooks = Book::getLatest(4); // 4 derniers livres
        $this->render('home/index', [
            'userCount' => $userCount,
            'latestBooks' => $latestBooks
        ]);
    }
}
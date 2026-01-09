<?php

use Core\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $userCount = User::countUsers();
        $this->render('home/index', ['userCount' => $userCount]);
    }
}

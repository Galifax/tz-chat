<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(UserService $userService): Response
    {
        return Inertia::render('Dashboard', [
            'users' => $userService->list(Auth::id()),
        ]);
    }
}

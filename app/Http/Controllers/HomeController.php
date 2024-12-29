<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController
{
    /**
     * Handle the incoming request.
     *
     * @return View
     */
    public function __invoke(): View
    {
        return view('home');
    }
}

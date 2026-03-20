<?php

namespace App\Http\Controllers;

use Inertia\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('About');
    }
}

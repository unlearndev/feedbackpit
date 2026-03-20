<?php

namespace App\Http\Controllers;

use Inertia\Response;

class LandingController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Landing');
    }
}

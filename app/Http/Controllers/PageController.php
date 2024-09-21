<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $image_logo = asset('images/LOGO-HOME.svg');

        $image_partner = asset('images/icon-empresa.svg');
        return Inertia::render('Welcome', [
            'image_logo' => $image_logo,
            'image_partner' => $image_partner,
        ]);
    }
}

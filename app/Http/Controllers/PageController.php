<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $image_logo = asset('images/LOGO-HOME.svg');
        $image_partner = asset('images/icon-empresa.svg');
        $image_logo_softweek = asset('images/LOGO_SOFTWEEK.svg');
        $images_last_edition = [
            asset('images/last_editions/lasted1.png'),
            asset('images/last_editions/lasted2.png'),
            asset('images/last_editions/lasted3.png'),
            asset('images/last_editions/lasted4.png'),
            asset('images/last_editions/lasted5.png'),
            asset('images/last_editions/lasted6.png'),
            asset('images/last_editions/lasted7.png'),
            asset('images/last_editions/lasted8.png'),
            asset('images/last_editions/lasted9.png'),
            asset('images/last_editions/lasted10.png'),
        ];

        return Inertia::render('Welcome', [
            'image_logo' => $image_logo,
            'image_partner' => $image_partner,
            'image_logo_softweek' => $image_logo_softweek,
            'images_last_edition' => $images_last_edition,
        ]);
    }
}

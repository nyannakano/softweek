<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\SubscriptionService;
use Inertia\Inertia;

class PageController extends Controller
{
    protected EventService $eventService;
    protected SubscriptionService $subscriptionService;

    public function __construct(EventService $eventService, SubscriptionService $subscriptionService)
    {
        $this->eventService = $eventService;
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $image_logo = asset('images/LOGO-HOME.svg');
        $image_logo_softweek = asset('images/LOGO_SOFTWEEK.svg');
        $image_eng_soft = asset('images/engsoft.svg');
        $image_campo_real = asset('images/camporeal.png');
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

        $images_master = [
            asset('images/MASTER/shootinghouse.png'),
            asset('images/MASTER/teorema.png'),
        ];

        $images_knight = [
            asset('images/KNIGHT/3c.png'),
            asset('images/KNIGHT/dam.png'),
        ];

        $image_force = [
            asset('images/FORCE/palinha.svg'),
            asset('images/FORCE/cooperalianca.png'),
        ];

        $image_jedi = [
            asset('images/JEDI/dalpozzo.png'),
            asset('images/JEDI/fuel.png'),
            asset('images/JEDI/nexun.png'),
            asset('images/JEDI/rp.png'),
            asset('images/JEDI/santamaria.png'),
            asset('images/JEDI/spa.png'),
            asset('images/JEDI/unimed.png'),
        ];

        $image_padawan = [
            asset('images/PADAWAN/act.png'),
            asset('images/PADAWAN/celeiro.png'),
            asset('images/PADAWAN/ctp.png'),
            asset('images/PADAWAN/lets.png'),
            asset('images/PADAWAN/NextAge.png'),
        ];

        $images_partners = [
            'jedi' => $image_jedi,
            'padawan' => $image_padawan,
            'force' => $image_force,
            'knight' => $images_knight,
            'master' => $images_master,
        ];

        $metrics = $this->eventService->getMetrics();
        $events = $this->eventService->getEventsPerDay();

        return Inertia::render('Welcome', [
            'image_logo' => $image_logo,
            'images_partners' => $images_partners,
            'image_logo_softweek' => $image_logo_softweek,
            'images_last_edition' => $images_last_edition,
            'metrics' => $metrics,
            'events' => $events,
            'image_eng_soft' => $image_eng_soft,
            'image_campo_real' => $image_campo_real,
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin');
        }

        $logo = asset('images/LOGO_SOFTWEEK.svg');

        $events = $this->eventService->getEventsPerDay();
        $is_already_subbed = $this->subscriptionService->isSubscribed($user);
        $subscription = null;

        if ($is_already_subbed) {
            $subscription = $this->subscriptionService->getSubscription($user);
        }

        $lunches = $this->eventService->getLunches('lunch');
        $drinks = $this->eventService->getLunches('drink');

        return Inertia::render('Dashboard', [
            'logo' => $logo,
            'events' => $events,
            'lunches' => $lunches,
            'drinks' => $drinks,
            'is_already_subbed' => $is_already_subbed,
            'subscription' => $subscription,
        ]);
    }

    public function admin()
    {
        return view('admin.admin');
    }

    public function workshops()
    {
        $workshops = $this->eventService->getEventsAsAdmin();
        $workshops->each(function ($workshop) {
            $total_slots = $workshop->slots + $workshop->subscriptions()->where('status', 'paid')->count();
            $workshop->total_slots = $total_slots;
        });

        return view('admin.workshops', compact('workshops'));
    }
}

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
        $image_partner = asset('images/icon-empresa.svg');
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

        $metrics = $this->eventService->getMetrics();
        $events = $this->eventService->getEventsPerDay();

        return Inertia::render('Welcome', [
            'image_logo' => $image_logo,
            'image_partner' => $image_partner,
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

        return view('admin.workshops', compact('workshops'));
    }
}

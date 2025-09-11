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
        $image_logo = asset('images/LOGO-HOME.png');
        $image_logo_softweek = asset('images/LOGO_SOFTWEEK.png');
        $image_eng_soft = asset('images/engsoft.svg');
        $image_25_anos = asset('images/25anos.png');
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
        ];

        $image_ouro = [
            asset('images/OURO/fuel.png'),
            asset('images/OURO/teorema.png'),
            asset('images/OURO/Zaaz.png'),
        ];

        $image_prata = [
            asset('images/PRATA/3c.png'),
            asset('images/PRATA/act.jpeg'),
            asset('images/PRATA/bridge.jpg'),
            asset('images/PRATA/celeiro.png'),
            asset('images/PRATA/cilla.png'),
            asset('images/PRATA/dam.png'),
            asset('images/PRATA/izi.png'),
            asset('images/PRATA/mensagio.png'),
            asset('images/PRATA/NextAge.png'),
            asset('images/PRATA/spa.png'),
        ];

        $image_parceiros = [
            asset('images/PARCEIROS/cooper.png'),
            asset('images/PARCEIROS/dalpozzo.png'),
            asset('images/PARCEIROS/governize.png'),
            asset('images/PARCEIROS/palinha.jpeg'),
            asset('images/PARCEIROS/santamaria.png'),
            asset('images/PARCEIROS/sebrae.png'),
            asset('images/PARCEIROS/sec.png'),
        ];

        $images_partners = [
            'master' => $images_master,
            'ouro' => $image_ouro,
            'prata' => $image_prata,
            'parceiros' => $image_parceiros,
        ];

        $metrics = $this->eventService->getMetrics();
        $events = $this->eventService->getEventsPerDayHome();

        return Inertia::render('Welcome', [
            'image_logo' => $image_logo,
            'images_partners' => $images_partners,
            'image_logo_softweek' => $image_logo_softweek,
            'image_25_anos' => $image_25_anos,
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

        $logo = asset('images/LOGO_SOFTWEEK.png');

        $events = $this->eventService->getEventsPerDay();
        $is_already_subbed = $this->subscriptionService->isSubscribed($user);
        $subscription = null;

        if ($is_already_subbed) {
            $subscription = $this->subscriptionService->getSubscription($user);

            $checkIfAlreadyHaveEvents = $this->subscriptionService->checkIfAlreadyHaveEvents($user);
        }

        $drinks = $this->eventService->getLunches('drink');

        return Inertia::render('Dashboard', [
            'logo' => $logo,
            'events' => $events,
            'drinks' => $drinks,
            'is_already_subbed' => $is_already_subbed,
            'alreadyHaveEvents' => $checkIfAlreadyHaveEvents ?? false,
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
            $total_slots = $workshop->slots + $workshop->subscriptions()->count();
            $workshop->total_slots = $total_slots;
        });

        return view('admin.workshops', compact('workshops'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Event;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'events'    => Event::orderBy('sort_order')->orderBy('event_date', 'desc')->get(),
            'documents' => Document::orderBy('sort_order')->orderBy('published_date', 'desc')->get(),
            'stats' => [
                'totalEvents'    => Event::count(),
                'totalDocs'      => Document::count(),
                'totalProyeccionSocial' => Event::where('is_proyeccion_social', true)->count(),
            ],
            'activeTab' => 'overview',
        ]);
    }
}

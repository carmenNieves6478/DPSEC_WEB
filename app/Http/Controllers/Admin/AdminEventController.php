<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminEventController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'events' => Event::orderBy('sort_order')->orderBy('event_date', 'desc')->get(),
            'activeTab' => 'events',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'type'                => 'required|string|max:100',
            'category'            => 'required|string|max:100',
            'event_date'          => 'required|date',
            'time'                => 'nullable|string|max:50',
            'location'            => 'required|string|max:255',
            'organizer'           => 'required|string|max:255',
            'description'         => 'required|string',
            'image_path'          => 'nullable|url|max:1000',
            'fb_link'             => 'nullable|url|max:1000',
            'is_proyeccion_social' => 'boolean',
            'sort_order'          => 'integer',
        ]);

        Event::create($validated);

        return redirect()->back()->with('success', 'Evento registrado correctamente.');
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'type'                => 'required|string|max:100',
            'category'            => 'required|string|max:100',
            'event_date'          => 'required|date',
            'time'                => 'nullable|string|max:50',
            'location'            => 'required|string|max:255',
            'organizer'           => 'required|string|max:255',
            'description'         => 'required|string',
            'image_path'          => 'nullable|url|max:1000',
            'fb_link'             => 'nullable|url|max:1000',
            'is_proyeccion_social' => 'boolean',
            'sort_order'          => 'integer',
        ]);

        $event->update($validated);

        return redirect()->back()->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();
        return redirect()->back()->with('success', 'Evento eliminado.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminDocumentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'documents' => Document::orderBy('sort_order')->orderBy('published_date', 'desc')->get(),
            'activeTab' => 'docs',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:100|unique:documents,code',
            'category'       => 'required|string|max:100',
            'published_date' => 'required|date',
            'description'    => 'nullable|string',
            'file_path'      => 'nullable|url|max:1000',
            'is_active'      => 'boolean',
            'sort_order'     => 'integer',
        ]);

        Document::create($validated);

        return redirect()->back()->with('success', 'Documento registrado correctamente.');
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:100|unique:documents,code,' . $document->id,
            'category'       => 'required|string|max:100',
            'published_date' => 'required|date',
            'description'    => 'nullable|string',
            'file_path'      => 'nullable|url|max:1000',
            'is_active'      => 'boolean',
            'sort_order'     => 'integer',
        ]);

        $document->update($validated);

        return redirect()->back()->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $document->delete();
        return redirect()->back()->with('success', 'Documento eliminado.');
    }
}

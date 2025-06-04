<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Toon de algemene bibliotheekpagina.
     * Deze pagina is publiek toegankelijk.
     */
    public function exploreLibrary()
    {
        return view('pages.library');
    }

    /**
     * Toon de interactieve leeromgeving.
     * Ook publiek toegankelijk.
     */
    public function interactiveLearning()
    {
        return view('pages.interactive-learning');
    }

    /**
     * Toon de samenwerkingsprojecten-pagina.
     * Alleen toegankelijk voor ingelogde gebruikers.
     */
    public function collaborationProjects()
    {
        // Zorg dat alleen ingelogde gebruikers deze pagina zien.
        if (!auth()->check()) {
            abort(403, 'Je moet ingelogd zijn om deze pagina te bekijken.');
        }

        return view('pages.collaboration-projects');
    }
}

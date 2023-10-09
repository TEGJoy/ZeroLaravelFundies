<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tournaments = Tournament::latest()->paginate(5);
        //Voeg nog een totaal aantal signups toe.
        return view('tournaments.index', compact('tournaments'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function byGenre(int $genreId)
    {

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function byGame(string $game){
        /* Pseudo-code
        $tournament = Tournament::find($game)
        return view('tournaments.by-game', compact('tournaments'))
        */
    }
}

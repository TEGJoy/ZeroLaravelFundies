<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Auth;
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
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'max' => 'required|numeric',
            'description' => 'required|string',
            'created_by' => 'numeric',
        ]);
        $request['is_active'] = 1;
        $request['created_by'] = Auth::user()->id;
        Tournament::create($request->all());
        return redirect()->route('tournaments.index')
        ->with('success', 'Tournament created succesfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::find($id);
        return view('tournaments.show', compact('tournament'));
    }
    public function byGenre(int $genreId)
    {

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = Tournament::find($id);
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'max' => 'required',
            'description' => 'required|string',
          ]);
          $tournament = Tournament::find($id);
          $tournament->update($request->all());
          return redirect()->route('tournaments.index')
            ->with('success', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = Tournament::find($id);
        $tournament->delete();
        return redirect()->route('tournaments.index')
          ->with('success', 'Tournament deleted successfully.');
    }
    public function byGame(string $game){
        /* Pseudo-code
        $tournament = Tournament::find($game)
        return view('tournaments.by-game', compact('tournaments'))
        */
    }
}

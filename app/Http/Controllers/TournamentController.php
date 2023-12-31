<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\WaitingList;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Auth;
use Carbon\Carbon;
class TournamentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function superUser(){
        return Waitinglist::where('user_id', '=',Auth::user()->id)->
        with('tournaments')->count();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //$superUser = $this->superUser();
        if (request('search')) {
            $tournaments = Tournament::where('name', 'like', '%' . request('search') . '%')->where('is_active','=','1')->get();
        } else {
            $tournaments = Tournament::all()
            ->where('is_active','=','1');
        }
        //Voeg nog een totaal aantal signups toe.
        return view('tournaments.index', compact('tournaments'))
                ->with('i');
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = Tournament::find($id);
        if ($tournament->created_by === auth()->id() || Auth::user()->is_admin) {
            return view('tournaments.edit', compact('tournament'));
        }
        else{
            return redirect()->route('tournaments.index')
            ->with('error', 'Dit is niet jouw toernooi.');
        }
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
        if ($tournament->created_by === auth()->id() || Auth::user()->is_admin) {
            $tournament->update($request->all());
        }
        else{
            return redirect()->route('tournaments.index')
            ->with('error', 'Dit is niet jouw toernooi.');
        }
          return redirect()->back()
            ->with('success', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = Tournament::find($id);
        if ($tournament->created_by === auth()->id() || Auth::user()->is_admin) {
            $tournament->update(['is_active' => 0]);
        }
        else{
            return redirect()->route('tournaments.index')
            ->with('error', 'Dit is niet jouw toernooi.');
        }
        return redirect()->back()
          ->with('success', 'Tournament set inactive successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function setState(string $id)
    {
        $tournament = Tournament::find($id);
        if ($tournament->created_by === auth()->id() || Auth::user()->is_admin) {
            if($tournament->is_active == 0){
                $tournament->update(['is_active' => 1]);
            }
            else{
                $tournament->update(['is_active' => 0]);
            }
        }
        else{
            return redirect()->route('tournaments.index')
            ->with('error', 'Dit is niet jouw toernooi.');
        }
        return redirect()->back()
          ->with('success', 'Tournament state changed successfully.');
    }
    public function byGame(string $game){
        /* Pseudo-code
        $tournament = Tournament::find($game)
        return view('tournaments.by-game', compact('tournaments'))
        */
    }
}

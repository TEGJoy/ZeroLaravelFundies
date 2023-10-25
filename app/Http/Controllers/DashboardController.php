<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Auth;
use App\Models\WaitingList;
class DashboardController extends Controller
{
    public function superUser(){
        return Waitinglist::where('user_id', '=', auth()->id())
        ->count();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $superUser = $this->superUser();
        if (request('search')) {
            $tournaments = Tournament::where('name', 'like', '%' . request('search') . '%')
            ->where('user_id', '=', auth()->id())
            ->get();
        } else if(!Auth::user()->is_admin) {
            $tournaments = Tournament::latest()->paginate(5)
            ->where('user_id', '=', auth()->id());
        } else{
            $tournaments = Tournament::latest()->paginate(5);
        }
        //Voeg nog een totaal aantal signups toe.
        return view('dashboards.index', compact('tournaments'))
                ->with('i', (request()->input('page', 1) - 1) * 5)
                ->with(compact('superUser'));
    }
}

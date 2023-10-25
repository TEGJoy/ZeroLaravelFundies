<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Auth;
class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (request('search')) {
            $tournaments = Tournament::where('name', 'like', '%' . request('search') . '%')->get();
        } else {
            $tournaments = Tournament::latest()->paginate(5);
        }
        //Voeg nog een totaal aantal signups toe.
        return view('tournaments.index', compact('tournaments'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}

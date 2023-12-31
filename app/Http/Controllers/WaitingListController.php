<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\WaitingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Auth;
use DB;
class WaitingListController extends Controller
{
         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        /* Originele query
        SELECT DISTINCT c.ID, c.name FROM `waiting_lists` as a
            JOIN tournaments as c ON a.tournament_id = c.id
            WHERE c.is_active = 1
            //optioneel voor gebruiker alleen
             AND a.user_id = " . $_SESSION['id'] . "
            //optioneel voor zoekfunctie
            AND c.name like %whatever%
            ORDER BY c.name
        */
        if (request('search')) {
            $tournamentWaitingLists = DB::table('waiting_lists')
            ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
            ->join('users', 'users.id', '=', 'waiting_lists.user_id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->where('tournaments.name','like', '%' . request('search') . '%')
            ->get();
        } else if(!Auth::user()->is_admin) {
            $tournamentWaitingLists = DB::table('waiting_lists')
            ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
            ->join('users', 'users.id', '=', 'waiting_lists.user_id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->where('waiting_lists.user_id', '=', auth()->id())
            ->get();
        } else {
            $tournamentWaitingLists = DB::table('waiting_lists')
            ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
            ->join('users', 'users.id', '=', 'waiting_lists.user_id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->get();
        }
       /*
        $i = 0;
        foreach($uniqueTournaments as $uniqueTournament){
            $tournamentWaitingList = DB::table('waiting_lists')
            ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
            ->join('users', 'users.id', '=', 'waiting_lists.user_id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->where('tournaments.name', '=', $uniqueTournament->name)
            ->get();

            $tournamentWaitingLists = $tournamentWaitingListsEmpty->mergeRecursive($tournamentWaitingList);

        }
        dd($tournamentWaitingLists);
        */
        /* tweede originele query
            SELECT a.id as signID, a.tournament_id, b.id, b.name FROM `waiting_lists` as a JOIN users as b ON a.user_id = b.id JOIN tournaments as c ON a.tournament_id = c.id WHERE c.is_active = 1 AND c.name = 'Dnf Duel'
        */
        //Voeg nog een totaal aantal signups toe.
        if(Auth::user()->is_admin){
        return view('waitinglists.admin', compact('tournamentWaitingLists'))
                ->with('i');
        } else {
            return view('waitinglists.index', compact('tournamentWaitingLists'))
            ->with('i');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournamentSpecifics = DB::table('waiting_lists')
        ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
        ->join('users', 'users.id', '=', 'waiting_lists.user_id')
        ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
        ->where('tournaments.is_active', '=', 1)
        ->where('tournaments.id', '=', $id)
        ->get();
        return view('waitinglists.show', compact('tournamentSpecifics'));
    }
     /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $waitinglist = WaitingList::find($id);
        if ($waitinglist->user_id === auth()->id() || Auth::user()->is_admin) {
            $waitinglist->delete();
        }
        else{
            return redirect()->back()
            ->with('error', 'Jij mag niet iemand anders uitschrijven lol.');
        }
        return redirect()->back()
          ->with('success', 'Removed successfully.');
    }
    public function join(string $id){
        $tournament = Tournament::find($id);
        return view('tournaments.join',compact('tournament'));
    }
    public function joinHandler(Request $request, string $tournamentId){
        $userId = Auth::user()->id;
        $joined = $this->checkJoined($userId, $tournamentId);
        if($joined){
            return redirect()->route('tournaments.index')
            ->with('error', 'Already joined tournament.');
        }
        $request['user_id'] = $userId;
        $request['tournament_id'] = $tournamentId;
        WaitingList::create($request->all());
        return redirect()->route('tournaments.index')
        ->with('success', 'Succesfully joined tournament.');
    }
    public function checkJoined($userId, $tournamentId){
        $checkJoined = DB::table('waiting_lists')
        ->where('user_id','=',$userId)
        ->where('tournament_id','=',$tournamentId)
        ->count();
        if($checkJoined > 0){
            return true;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\WaitingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Auth;
use DB;
class WaitingListController extends Controller
{
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
            $uniqueTournaments = DB::table('waiting_lists')
            ->distinct()
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('waiting_lists.is_active', '=', 1)
            ->where('tournaments.name','like', '%' . request('search') . '%')
            ->get();
        } else {
            $uniqueTournaments = DB::table('waiting_lists')
            ->select('tournaments.name', 'tournaments.name as name', 'tournaments.id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->groupBy('tournaments.name', 'tournaments.id')
            ->get();
        }
        foreach($uniqueTournaments as $uniqueTournament){
            $tournamentWaitingList = DB::table('waiting_lists')
            ->select('waiting_lists.id', 'waiting_lists.id as signID', 'waiting_lists.tournament_id', 'users.id', 'users.name', 'tournaments.name as tournament_name')
            ->join('users', 'users.id', '=', 'waiting_lists.user_id')
            ->join('tournaments', 'tournaments.id', '=', 'waiting_lists.tournament_id')
            ->where('tournaments.is_active', '=', 1)
            ->where('tournaments.name', '=', $uniqueTournament->name)
            ->get();

            $tournamentWaitingListMerged[] = $tournamentWaitingList;
        }
        //dd($tournamentWaitingListMerged);
        /* tweede originele query
            SELECT a.id as signID, a.tournament_id, b.id, b.name FROM `waiting_lists` as a JOIN users as b ON a.user_id = b.id JOIN tournaments as c ON a.tournament_id = c.id WHERE c.is_active = 1 AND c.name = 'Dnf Duel'
        */
        //Voeg nog een totaal aantal signups toe.
        return view('waitinglists.index', compact('tournamentWaitingListMerged'))
                ->with('i');
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
    public function getTournamentName($id){
        $tournament = DB::table('tournaments')
        ->select('name as tournament')
        ->where('id','=',$id)
        ->get();
        return $tournament;
    }
}

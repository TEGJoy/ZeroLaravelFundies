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

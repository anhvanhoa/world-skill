<?php

namespace App\Http\Controllers;
use App\Models\Events;

use Illuminate\Http\Request;

class TicketEventController extends Controller
{
    function ticketShow(Request $req, $id) {
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('id', $id)->first();
        return view('tickets.create', compact(['event']));
    }
    
    function ticketHandle(Request $req, $id) {
        $req->validate([
            'name'=> 'required',
            'cost'=> 'required',
        ], [
            'name.required'=> 'name Khong duoc bo trong !',
            'cost.required'=> 'cost Khong duoc bo trong !',
        ]);
        if($req->special_validity === 'date' && !$req->valid_until) return redirect()->back()->with('date', 'date Khong duoc bo trong !');
        if($req->special_validity === 'amount' && !$req->amount) return redirect()->back()->with('amount', 'amount Khong duoc bo trong !');
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('id', $id)->first();
        return redirect()->route('event',$event->slug)->with('date', 'date Khong duoc bo trong !');
    }
}

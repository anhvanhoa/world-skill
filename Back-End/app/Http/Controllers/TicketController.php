<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Tickets;

class TicketController extends Controller
{
    public function formCreate($slug)
    {
        $event = Events::where("slug", $slug)->first();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("tickets.create", compact("event"));
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "cost" => "required",
            "valid_until" => "required",
        ], [
            "name.required" => "Tên không được để trống",
            "cost.required" => "Giá không được để trống",
            "valid_until.required" => "valid_until không được để trống",
        ]);
        $special_validity = null;
        if ($request->special_validity === 'amount') {
            $special_validity = '{"type": "amount", "amount": ' . $request->valid_until . '}';
        } else if ($request->special_validity === 'date') {
            $special_validity = '{"type": "date", "date": "' . $request->valid_until . '"}';
        }
        $ticket = new Tickets();
        $ticket->name = $request->name;
        $ticket->cost = $request->cost;
        $ticket->event_id = $id;
        $ticket->special_validity = $special_validity;
        $ticket->save();
        return redirect()->route('detail-event', $request->slug)->with('success', 'Vé được tạo thành công');
    }
}

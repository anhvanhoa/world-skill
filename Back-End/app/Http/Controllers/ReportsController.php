<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Rooms;
use App\Models\Channels;
use App\Models\Sessions;
use App\Models\SessionRegistrations;
use Illuminate\Broadcasting\Channel;

class ReportsController extends Controller
{
    public function index($slug)
    {
        $event = Events::where("slug", $slug)->first();
        $channels = Channels::where("event_id", $event->id)->get();
        $rooms = Rooms::whereIn("channel_id", $channels->pluck('id'))->get();
        foreach ($rooms as  $value) {
            $sessions = Sessions::where('room_id', $value->id)->pluck("id");
            $count = SessionRegistrations::whereIn("session_id", $sessions)->count();
            $value->count  = $count;
        }
        return view("reports.index", compact(['event', 'rooms']));
    }
}

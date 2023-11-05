<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Rooms;
use App\Models\Channels;


class RoomController extends Controller
{
    public function index($slug)
    {
        $event = Events::where("slug", $slug)->first();
        $channels = Channels::where("event_id", $event->id)->get();
        return view("rooms.create", compact(["event", "channels"]));
    }
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required",
            "capacity" => "required"
        ], [
            "name.required" => "Tên không được để trống",
            "capacity.required" => "Công xuất không được để trống"
        ]);
        $room = new Rooms();
        $room->name = $request->name;
        $room->channel_id = $request->channel;
        $room->capacity = $request->capacity;
        $room->save();
        return redirect()->route("detail-event", $request->slug)->with("success", "Phòng được tạo thành công");
    }
}

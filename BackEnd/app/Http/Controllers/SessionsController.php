<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\Channels;
use App\Models\Rooms;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    function sessionShowAdd($id) {
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('id', $id)->first();
        $channels = Channels::where('event_id', $event->id);
        $rooms  = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
        foreach ($rooms as $room) {
            $channel = Channels::select('name')->where('id', $room->channel_id)->first();
            $room->name_channel = $channel->name;
        }
        return view("sessions.create", compact(["event", "rooms"]));
    }
    function sessionShowHandle($id) {
        $request->validate([
            "title" => "required",
            "speaker" => "required",
            "start" => "required",
            "room" => "required",
            "end" => "required",
            "description" => "required",
        ], [
            "title.required" => "Tiêu đề không được để trống",
            "speaker.required" => "Người trình bày không được để trống",
            "start.required" => "Thời gian bắt đầu không được để trống",
            "end.required" => "Thời gian kết thúc không được để trống",
            "description.required" => "Mô tả không được để trống",
            "room.required" => "Vui lòng tạo phòng",
        ]);
        $sessions = Sessions::where("room_id", $request->room)->get();
        foreach ($sessions as $session) {
            $isTime = strtotime($session->end) < strtotime($request->start);
            if (!$isTime) return redirect()->back()->with("error", "Phòng đã được sử dụng tại thời điểm này");
        }
        $session = new Sessions();
        if ($request->type == "talk") $session->cost = null;
        else $session->cost = $request->cost;
        $session->type = $request->type;
        $session->title = $request->title;
        $session->room_id = $request->room;
        $session->start = $request->start;
        $session->end = $request->end;
        $session->description = $request->description;
        $session->speaker = $request->speaker;
        $session->save();
        return redirect()->route('detail-event', $request->slug)->with('success', 'Phiên được tạo thành công');
    }
}

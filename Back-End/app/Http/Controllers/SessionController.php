<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Events;
use App\Models\Sessions;

class SessionController extends Controller
{
    public function formCreate($slug)
    {
        $event = Events::where("slug", $slug)->first();
        $rooms = DB::table("channels")->join("rooms", "channels.id", "=", "rooms.channel_id")->select("*", "channels.name as name_channel")->where("event_id", $event->id)->get();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("sessions.create", compact(["event", "rooms"]));
    }

    public function create(Request $request)
    {
        $request->validate([
            "title" => "required",
            "speaker" => "required",
            "start" => "required",
            "end" => "required",
            "description" => "required",
        ], [
            "title.required" => "Tiêu đề không được để trống",
            "speaker.required" => "Người trình bày không được để trống",
            "start.required" => "Thời gian bắt đầu không được để trống",
            "end.required" => "Thời gian kết thúc không được để trống",
            "description.required" => "Mô tả không được để trống",
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

    public function updateForm(Request $request, $id, $slug)
    {
        $event = Events::where("slug", $slug)->first();
        $rooms = DB::table("channels")->join("rooms", "channels.id", "=", "rooms.channel_id")->select("*", "channels.name as name_channel")->where("event_id", $event->id)->get();
        $session = Sessions::where("id", $id)->first();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("sessions.edit", compact(['event', 'rooms', 'session']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => "required",
            "speaker" => "required",
            "start" => "required",
            "end" => "required",
            "description" => "required",
        ], [
            "title.required" => "Tiêu đề không được để trống",
            "speaker.required" => "Người trình bày không được để trống",
            "start.required" => "Thời gian bắt đầu không được để trống",
            "end.required" => "Thời gian kết thúc không được để trống",
            "description.required" => "Mô tả không được để trống",
        ]);
        $session = Sessions::find($id);
        if ($request->type == "talk") $session->cost = null;
        else $session->cost = $request->cost;
        $session->type = $request->type;
        $session->title = $request->title;
        $session->room_id = $request->room;
        $session->start = $request->start;
        $session->end = $request->end;
        $session->description = $request->description;
        $session->speaker = $request->speaker;
        $session->update();
        return redirect()->route('detail-event', $request->slug)->with('success', 'Phiên cập nhật thành công');
    }
}

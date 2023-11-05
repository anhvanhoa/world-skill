<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Events;
use App\Models\Tickets;

class EventController extends Controller
{
    public function index()
    {
        $events = Events::where('organizer_id', session()->get('user')['id'])->get();
        // $events = DB::table('events')->join('event_tickets', 'event_tickets.event_id', '=', 'events.id')->join('registrations', 'registrations.ticket_id', "=", "event_tickets.id")->select("events.name", "events.slug", "events.date", DB::raw("Count(registrations.ticket_id) as count_user"))->groupBy('events.id')->where('organizer_id', session()->get('user')['id'])->get();
        return view("events.index", compact('events'));
    }
    public function formCreate()
    {
        return view("events.create");
    }
    public function create(Request $request)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:events|regex:/^[a-z0-9-\s]+$/",
            "date" => "required",
        ], [
            "name.required" => "Tên không được để trống.",
            "slug.required" => "Slug không được để trống.",
            "date.required" => "Ngày không được để trống.",
            "slug.unique" => "Slug đã được sử dụng.",
            "slug.regex" => "Slug không được để trống và chỉ chứa các ký
            tự a-z, 0-9 và '-'",
        ]);
        $event = new Events();
        $event->organizer_id = session()->get("user")["id"];
        $event->name = $request->name;
        $event->slug = $request->slug;
        $event->date = $request->date;
        $event->save();
        return redirect()->route("detail-event", $request->slug)->with('success', "Đã tạo sự kiện thành công");
    }
    public function detailEvent(Request $request, $slug)
    {
        // $event = DB::table("events")->join("event_tickets", "events.id", "=", "event_tickets.event_id")->select("*")->where("slug", $slug)->get();
        $event = Events::where("slug", $slug)->first();
        $tickets = Tickets::where("event_id", $event->id)->get();
        $sessions = DB::table("sessions")->join("rooms", "sessions.room_id", "=", "rooms.id")->join("channels", "channels.id", "=", "rooms.channel_id")->select("*", "rooms.name as name_room", "sessions.id as session_id")->where("event_id", $event->id)->get();
        $channels = DB::table("sessions")->join("rooms", "sessions.room_id", "=", "rooms.id")->join("channels", "channels.id", "=", "rooms.channel_id")->select("channels.name", DB::raw('COUNT(DISTINCT rooms.name) as count_room'), DB::raw('COUNT(sessions.id) as count_session'))->groupBy("channels.name")->where("event_id", $event->id)->get();
        $rooms = DB::table("sessions")->join("rooms", "sessions.room_id", "=", "rooms.id")->join("channels", "channels.id", "=", "rooms.channel_id")->distinct()->select('rooms.name', "rooms.id", "rooms.capacity")->where("event_id", $event->id)->get();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("events.detail", compact(['event', 'tickets', 'sessions', 'channels', "rooms"]));
    }

    public function editEvent(Request $request, $slug)
    {
        $event = Events::where("slug", $slug)->first();
        if (!$event) {
            return redirect()->route('event');
        }
        return view('events.edit', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:events|regex:/^[a-z0-9-\s]+$/",
            "date" => "required",
        ], [
            "name.required" => "Tên không được để trống.",
            "slug.required" => "Slug không được để trống.",
            "date.required" => "Ngày không được để trống.",
            "slug.unique" => "Slug đã được sử dụng.",
            "slug.regex" => "Slug không được để trống và chỉ chứa các ký
            tự a-z, 0-9 và '-'",
        ]);
        $event = Events::find($id);
        $event->name = $request->name;
        $event->slug = $request->slug;
        $event->date = $request->date;
        $event->save();
        return redirect()->route("detail-event", $request->slug)->with('success', 'Cập nhật sự kiện thành công');
    }
}

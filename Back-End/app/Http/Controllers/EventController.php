<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Events;
use App\Models\Registrations;
use App\Models\Tickets;
use App\Models\Sessions;
use App\Models\Channels;
use App\Models\Rooms;

class EventController extends Controller
{
    public function index()
    {
        $events = Events::where('organizer_id', session()->get('user')['id'])->get();
        foreach ($events as  $event) {
            $tickets = Tickets::where('event_id', $event->id)->get();
            $count = 0;
            foreach ($tickets as $ticket) {
                $registrations = Registrations::where('ticket_id', $ticket->id)->count();
                $count += $registrations;
            }
            $event->count_user = $count;
        }
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
        $event = Events::where("slug", $slug)->first();
        $tickets = Tickets::where("event_id", $event->id)->get();
        $channels = Channels::where('event_id', $event->id)->get();
        $rooms = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
        $sessions = Sessions::whereIn('room_id', $rooms->pluck('id'))->get();
        foreach ($sessions as $session) {
            $room = Rooms::where('id', $session->room_id)->first();
            $channel = Channels::where('id', $room->channel_id)->first();
            $session->channel = $channel->name;
            $session->room = $room->name;
        }
        foreach ($channels as $channel) {
            // $count_room = Rooms::where("channel_id", $channel->id)->distinct('id')->count();
            $rooms_channel = Rooms::where("channel_id", $channel->id)->get();
            $count_room = count($rooms_channel);
            $count_session = Sessions::whereIn('room_id', $rooms_channel->pluck('id'))->count();
            $channel->count_session =  $count_session;
            $channel->count_room =  $count_room;
        }
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
            "date" => "required",
            'slug' => [
                'required',
                'regex:/^[a-z0-9-\s]+$/',
                Rule::unique('events')->ignore($id, 'id')
            ],
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

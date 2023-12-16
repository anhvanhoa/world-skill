<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\Registrations;
use App\Models\Sessions;
use App\Models\Channels;
use App\Models\Rooms;

class EventsController extends Controller
{
    function eventsShow() {
        $events = Events::where('organizer_id', session()->get('user')['id'])->orderBy('date')->get();
        foreach ($events as $event) {
            $count = 0;
            $tickets = EventTickets::where('event_id', $event->id)->get();
            foreach ($tickets as $ticket) {
                $count += Registrations::where('ticket_id', $ticket->id)->count();
                $event->count = $count;
            }
        }
        return view('events.index', compact(['events']));
    }
    function eventAdd() {
        return view('events.create');
    }
    function eventHandle(Request $req) {
        $req->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:events|regex:/^[a-z0-9-_]+$/i',
            'date'=> 'required',
        ], [
            'name.required'=> 'name Khong duoc bo trong !',
            'slug.required'=> 'slug Khong duoc bo trong !',
            'date.required'=> 'date Khong duoc bo trong !',
            'slug.unique'=> 'Slug đã được sử dụng !',
            'slug.regex'=> "Slug không được để trống và chỉ chứa các ký
            tự a-z, 0-9 và '-' !",
        ]);
        $event = new Events();
        $event->organizer_id = session()->get("user")["id"];
        $event->name = $req->name; 
        $event->slug = "$req->slug"; 
        $event->date = $req->date; 
        $event->save();
        return redirect()->route('event', $req->slug)->with('success', 'Đã tạo sự kiện thành công');
    }
    function eventDetailShow($slug) {
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('slug', $slug)->first();
        $tickets = EventTickets::where('event_id',  $event->id)->get();
        $channels = Channels::where('event_id', $event->id)->get();
        $rooms = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
        $sessions = Sessions::whereIn('room_id', $rooms->pluck('id'))->get();
        foreach ($sessions as $session) {
            $room = $rooms->where('id',  $session->room_id)->first();
            $channel = $channels->where('id',  $room->channel_id)->first();
            $session->channel = $channel->name . ' / ' . $room->name;
        }
        foreach ($channels as $channel) {
            $room_counts = $rooms->where('channel_id', $channel->id);
            $session_counts = $sessions->whereIn('room_id',  $room_counts->pluck('id'))->count();
            $channel->room_count = count($room_counts);
            $channel->count_session = $session_counts;
        }
        return view('events.detail', compact(['event', 'tickets', 'sessions', 'rooms', 'channels']));
    }

    function eventEdit($id) {
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('id', $id)->first();
        return view('events.edit', compact(['event']));
    }
    function eventEditHandle(Request $req, $id) {
        $event = Events::where('organizer_id', session()->get('user')['id'])->where('id', $id)->first();
        $req->validate([
            'name'=> 'required',
            'slug'=> [
                'required',
                'regex:/^[a-z0-9-_]+$/i',
                Rule::unique('events')->ignore($id, 'id')
            ],
            'date'=> 'required',
        ], [
            'name.required'=> 'name Khong duoc bo trong !',
            'slug.required'=> 'slug Khong duoc bo trong !',
            'date.required'=> 'date Khong duoc bo trong !',
            'slug.unique'=> 'Slug đã được sử dụng !',
            'slug.regex'=> "Slug không được để trống và chỉ chứa các ký
            tự a-z, 0-9 và '-' !",
        ]);
        $event = Event::find($id);
        $event->name = $req->name; 
        $event->slug = "$req->slug"; 
        $event->date = $req->date; 
        $event->save();
        return redirect()->route('event', $req->slug)->with('success', 'Cập nhập sự kiện thành công');
    }
}

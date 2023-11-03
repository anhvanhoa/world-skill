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
        return redirect()->route("detail-event", $request->slug);
    }
    public function detailEvent(Request $request, $slug)
    {
        // $event = DB::table("events")->join("event_tickets", "events.id", "=", "event_tickets.event_id")->select("*")->where("slug", $slug)->get();
        $event = Events::where("slug", $slug)->first();
        $tickets = Tickets::where("event_id", $event->id)->get();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("events.detail", compact('event'), compact('tickets'));
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
        return redirect()->route("detail-event", $request->slug);
    }
}

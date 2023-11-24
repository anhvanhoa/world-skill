<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Organizers;
use App\Models\Channels;
use App\Models\Sessions;
use App\Models\Tickets;
use App\Models\Rooms;
use App\Models\Attendees;
use App\Models\Registrations;
use App\Models\SessionRegistrations;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    public function index()
    {
        $events = Events::all();
        foreach ($events as $event) {
            $event->organizer = Organizers::select('id', 'name', 'slug')->where('id', $event->organizer_id)->first();
        }
        return response()->json($events);
    }
    public function detailEvent($organizerSlug, $eventSlug)
    {
        $organizer = Organizers::where('slug', $organizerSlug)->first();
        if (!$organizer) return response()->json(["message" => "Không tìm thấy nhà tổ chức"], 404);
        $event = Events::where('organizer_id', $organizer->id)->where('slug', $eventSlug)->first();
        if (!$event) return response()->json(["message" => "Không tìm sự kiện"], 404);
        $channels = Channels::where('event_id', $event->id)->get();
        $tickets = Tickets::where('event_id', $event->id)->get();
        $event->tickets = $tickets;
        foreach ($channels as $channel) {
            $rooms = Rooms::where('channel_id', $channel->id)->get();
            $channel->rooms = $rooms;
            foreach ($rooms as $room) {
                $sessions = Sessions::where('room_id', $room->id)->get();
                $room->sessions = $sessions;
            }
        }
        $event->channels = $channels;
        return response()->json($event, 200);
    }

    public function registration(Request $request, $organizerSlug, $eventSlug)
    {
        $token = $request->query('token');
        $attendee = Attendees::where('login_token', $token)->first();
        if (!$attendee) return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);
        // $organizer = Organizers::where('slug', $organizerSlug)->first();
        // $check = true;
        // if (!$organizer) {
        //     $check = false;
        // } else {
        //     $event = Events::where('organizer_id', $organizer->id)->where('slug', $eventSlug)->first();
        //     if (!$event) {
        //         $check = false;
        //     } else {
        //         $ticket = Tickets::where('event_id', $event->id)->find($request->ticket_id);
        //     }
        // }
        $ticket = Tickets::find($request->ticket_id);
        if (!$ticket) return response()->json(['message' => 'Vé không sẵn có'], 401);
        $isRegistration = Registrations::where('attendee_id', $attendee->id)->where('ticket_id', $ticket->id)->first();
        if ($isRegistration) return response()->json(['message' => 'Người dùng đã đăng ký'], 401);
        $registration = new Registrations();
        $registration->attendee_id = $attendee->id;
        $registration->ticket_id = $ticket->id;
        $registration->registration_time = date('Y-m-d H:i:s');
        $registration->save();
        foreach ($request->session_ids as $session_id) {
            $session = Sessions::find($session_id);
            $session_registration = new SessionRegistrations();
            $session_registration->registration_id = $registration->id;
            $session_registration->session_id = $session->id;
            $session_registration->save();
        }
        return response()->json(['message' => 'Đăng ký thành công'], 200);
    }

    public function getRegistration(Request $request)
    {
    }
}

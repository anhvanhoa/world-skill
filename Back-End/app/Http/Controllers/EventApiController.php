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
        $event = Events::where('organizer_id', $organizer->id)->where('slug', $eventSlug)->select('id', 'name', 'slug', 'date')->first();
        if (!$event) return response()->json(["message" => "Không tìm sự kiện"], 404);
        $channels = Channels::where('event_id', $event->id)->get();
        $tickets = Tickets::where('event_id', $event->id)->get();
        foreach ($tickets as $ticket) {
            $ticket->available = true;
            $special_validity = json_decode($ticket->special_validity);
            if (!$special_validity) $ticket->description = $special_validity;
            else {
                if ($special_validity->type == 'date')
                    $ticket->description = "Sẵn có đến ngày $special_validity->date";
                // if ($special_validity->type == 'amount')
                // $ticket->available = true;
            }
        }
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
        $ticket = Organizers::where('slug', $organizerSlug)->first();
        if ($ticket) $ticket = Events::where('organizer_id', $ticket->id)->where('slug', $eventSlug)->first();
        if ($ticket) $ticket = Tickets::where('event_id', $ticket->id)->find($request->ticket_id);
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
        $token = $request->query('token');
        $attendee = Attendees::where('login_token', $token)->first();
        if (!$attendee) return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);
        $registrations = Registrations::where('attendee_id', $attendee->id)->get();
        $tickets = Tickets::whereIn('id', $registrations->pluck('ticket_id'))->get();
        $events = Events::whereIn('id', $tickets->pluck('event_id'))->get();
        $res = [
            'registrations' => []
        ];
        foreach ($events as $event) {
            $registrations = [];
            $organizer = Organizers::where('id', $event->id)->select('id', 'name', 'slug')->first();
            $event->organizer = $organizer;
            $registrations['event'] = $event;
            $channels = Channels::where('event_id', $event->id);
            $rooms = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
            $sessions = Sessions::whereIn('room_id', $rooms->pluck('id'))->select('id')->get();
            $session_ids = [];
            foreach ($sessions as $session) {
                array_push($session_ids,  $session->id);
            }
            $registrations['session_ids'] = $session_ids;
            array_push($res['registrations'],  $registrations);
        }
        return response()->json($res, 200);
    }
}

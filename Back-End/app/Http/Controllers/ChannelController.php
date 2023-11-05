<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Channels;

class ChannelController extends Controller
{
    public function index($slug)
    {
        $event = Events::where("slug", $slug)->first();
        return view("channels.create", compact(["event"]));
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
        ], [
            "name.required" => "Tên không được để trống",
        ]);
        $channel = new Channels();
        $channel->name = $request->name;
        $channel->event_id = $id;
        $channel->save();
        return redirect()->route("detail-event", $request->slug)->with("success", "Tạo thành công kênh");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class SessionController extends Controller
{
    public function formCreate($slug)
    {
        $event = Events::where("slug", $slug)->first();
        if (!$event) {
            return redirect()->route('event');
        }
        return view("sessions.create", compact("event"));
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
    }
}

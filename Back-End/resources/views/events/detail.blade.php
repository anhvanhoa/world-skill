<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Backend</title>

    <base href="{{ asset('') }}">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="events/index.html">Nền tảng sự kiện</a>
        <span class="navbar-organizer w-100">{{ session()->get('user')['name'] }}</span>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" id="logout" href="{{ route('logout') }}">Đăng xuất</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="events/index.html">Quản lý sự kiện</a></li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>{{ $event->name }}</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="events/detail.html">Tổng quan</a></li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Báo cáo</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item"><a class="nav-link" href="reports/index.html">Công suất phòng</a></li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                @if(Session::has('success'))
                <div class="alert alert-success mt-4">{{ Session::get('success') }}</div>
                @endif
                <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{ $event->name }}</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('edit-event',  $event->slug)}}" class="btn btn-sm btn-outline-secondary">Sửa sự kiện</a>
                            </div>
                        </div>
                    </div>
                    <span class="h6">{{ $event->date }}</span>
                </div>

                <!-- Tickets -->
                <div id="tickets" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Vé</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('create-ticket', $event->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Tạo vé mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row tickets">
                    @foreach ($tickets as $ticket)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{$ticket->name}}</h5>
                                <p class="card-text">{{ ceil($ticket->cost) }} -</p>
                                @if(!$ticket->special_validity)
                                <p class="card-text">&nbsp;</p>
                                @elseif(isset(json_decode($ticket->special_validity)->date))
                                <p class="card-text">Sẵn có cho đến {{date_format(date_create(json_decode($ticket->special_validity)->date), 'F d, Y')}}</p>
                                @else
                                <p class="card-text">{{json_decode($ticket->special_validity)->amount}} vé sẵn có</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Sessions -->
                <div id="sessions" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Phiên</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('session', $event->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Tạo phiên mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive sessions">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Loại</th>
                                <th class="w-100">Tiêu đề</th>
                                <th>Người trình bày</th>
                                <th>Kênh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                            <tr>
                                <td class="text-nowrap">{{date_format(date_create($session->start), "h:i")}} - {{date_format(date_create($session->end), "h:i")}}</td>
                                <td>{{$session->type}}</td>
                                <td><a href="{{route('edit-session', [$session->session_id, $event->slug])}}">{{$session->title}}</a></td>
                                <td class="text-nowrap">{{$session->speaker}}</td>
                                <td class="text-nowrap">{{$session->name}} / {{$session->name_room}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Channels -->
                <div id="channels" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Kênh</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('channel', $event->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Tạo kênh mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row channels">
                    @foreach($channels as $channel)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{$channel->name}}</h5>
                                <p class="card-text">{{$channel->count_session}} Phiên, {{$channel->count_room}} phòng</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Rooms -->
                <div id="rooms" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Phòng</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{route('room', $event->slug)}}" class="btn btn-sm btn-outline-secondary">
                                    Tạo phòng mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive rooms">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Công suất</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td>{{$room->name}}</td>
                                <td>{{$room->capacity}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

</body>

</html>
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
    <link href="assets/css/Chart.min.css" rel="stylesheet">
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
                <div class="border-bottom mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{ $event->name }}</h1>
                    </div>
                    <span class="h6">{{ $event->date }}</span>
                </div>

                <div class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Công suất phòng</h2>
                    </div>
                </div>

                <!-- TODO create chart here -->
                <canvas id="myChart" style="max-width: 500; max-height: 500;" width="400" height="400"></canvas>
            </main>
        </div>
    </div>
    <script src="assets/js/Chart.bundle.js"></script>
    <script src="assets/js/Chart.js"></script>
    <script>
        let nameRoom = [],
            capRoom = [],
            bgs = [],
            dataRoom1 = [];
        @foreach($rooms as $room)
        nameRoom.push("{{ $room->name }}")
        dataRoom1.push(Number("{{ $room->count }}"))
        capRoom.push(Number("{{ $room->capacity }}"))
        @endforeach

        capRoom.forEach((item, index) => {
            if (dataRoom1[index] > item) bgs.push('red');
            else bgs.push('rgba(75, 192, 192, 0.2)')
        })

        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nameRoom,
                datasets: [{
                        label: 'Người tham dự',
                        data: dataRoom1,
                        backgroundColor: bgs,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Công suất',
                        data: capRoom,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {}
        });
    </script>
</body>

</html>
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
    <script src="assets/js/main.js" defer></script>
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
                        <h2 class="h4">Tạo vé mới</h2>
                    </div>
                </div>

                <form class="needs-validation" novalidate action="{{ route('create-ticket', $event->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputName">Tên</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" placeholder="" value="">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputCost">Giá</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="inputCost" name="cost" placeholder="" value="">
                            @error('cost')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectSpecialValidity">Hiệu lực đặc biệt</label>
                            <select class="form-control" id="selectSpecialValidity" name="special_validity">
                                <option value="" selected>Không</option>
                                <option value="amount">Số lượng giới hạn</option>
                                <option value="date">Có thể mua đến ngày</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputAmount">Số lượng vé tối đa được bán</label>
                            <input type="number" class="form-control" id="inputAmount" name="valid_until" placeholder="" value="0">
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3 d-none ">
                            <label for="inputValidTill" class="valid_until">Vé có thể được bán đến</label>
                            <input type="text" class="form-control @error('valid_until') is-invalid @enderror" id="inputValidTill" name="valid_until" placeholder="yyyy-mm-dd HH:MM" value="0">
                            @error('valid_until')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="slug" value="{{ $event->slug }}">
                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Lưu vé</button>
                    <a href="events/detail.html" class="btn btn-link">Bỏ qua</a>
                </form>
            </main>
        </div>
    </div>

</body>

</html>
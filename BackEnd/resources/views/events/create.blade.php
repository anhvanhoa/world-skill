<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>Event Backend</title>

        <base href="{{asset('')}}" />
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- Custom styles -->
        <link href="assets/css/custom.css" rel="stylesheet" />
    </head>

    <body>
        <nav
            class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow"
        >
            <a
                class="navbar-brand col-sm-3 col-md-2 mr-0"
                href="events/index.html"
                >Nền tảng sự kiện</a
            >
            <span class="navbar-organizer w-100">{{session()->get('user')['name']}}</span>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" id="logout" href="{{route('logout')}}"
                        >Đăng xuất</a
                    >
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    href="events/index.html"
                                    >Quản lý sự kiện</a
                                >
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="h2">Quản lý sự kiện</h1>
                    </div>

                    <div class="mb-3 pt-3 pb-2">
                        <div
                            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center"
                        >
                            <h2 class="h4">Tạo sự kiện mới</h2>
                        </div>
                    </div>

                    <form
                        class="needs-validation"
                        novalidate
                        action="{{route('eventHandle')}}"
                        method="POST"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="inputName">Tên</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="inputName"
                                    name="name"
                                    placeholder=""
                                    value=""
                                />
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="inputSlug">Slug</label>
                                <input
                                    type="text"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    id="inputSlug"
                                    name="slug"
                                    placeholder=""
                                    value=""
                                />
                                @error('slug')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="inputDate">Ngày</label>
                                <input
                                    type="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    id="inputDate"
                                    name="date"
                                    placeholder="yyyy-mm-dd"
                                    value=""
                                />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mb-4" />
                        <button class="btn btn-primary" type="submit">
                            Lưu sự kiện
                        </button>
                        <a href="events/index.html" class="btn btn-link"
                            >Bỏ qua</a
                        >
                    </form>
                </main>
            </div>
        </div>
    </body>
</html>

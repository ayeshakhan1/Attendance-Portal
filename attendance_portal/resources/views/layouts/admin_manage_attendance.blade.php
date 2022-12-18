<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="{{ route('adminportal') }}"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline" style="color: #02b6bf"> <strong>ADMIN
                                PORTAL</strong></span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="{{ route('view_students_record') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline custom-text-color">Students</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin_manage_attendance') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline custom-text-color">Attendance</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('leave_requests') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline custom-text-color">Leave Requests</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('grades') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline custom-text-color">Grades</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports') }}" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span
                                    class="ms-1 d-none d-sm-inline custom-text-color">Attendance Report</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#"
                            class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/admin.jpg') }}" alt="avatar" width="40" height="40"
                                class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">Ayesha Khan</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <div class="container" style="width: 80%">

                    <div class="input-group">
                        <div class="form-outline" style="width: 400px">
                            <form method="get" action="{{ route('admin_manage_attendance') }}">
                                <input type="search" id="email" name="email" class="form-control"
                                    placeholder="Search email..." />
                        </div>
                        <button type="submit" class="btn btn-primary"> Search
                        </button>
                        </form>
                    </div>

                    <br><br><br>

                    @if (session()->has('flash_message'))
                        {{ session()->get('flash_message') }}
                    @else
                        @foreach ($name as $std)
                            <h4> {{ $std->full_name }}</h4>
                            <small> {{ $std->email }}</small>
                            <br><br><br>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#add">Add Attendance</button>
                            <br><br>
                            @if (session()->has('success'))
                                <div class="row">
                                    <div class="col-md-6 alert alert-success alert-dismissible fade show">
                                        {{ session()->get('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @elseif (session()->has('alert'))
                                <div class="row">
                                    <div class="col-md-6 alert alert-danger alert-dismissible fade show">
                                        {{ session()->get('alert') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @endif
                            <br><br>
                            <table class="table table-striped">
                                @php
                                    $sr = 1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th scope="col">Sr no.</th>
                                        <th scope="col">Attendance Date</th>
                                        <th scope="col">Attendance <small>(editable)</small></th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($att as $info)
                                        <tr>
                                            <th scope="row">{{ $sr++ }}</th>
                                            <td> {{ $info->attendance_date }}</td>
                                            <form action="{{ route('edit_attendance') }}" method="post"
                                                style="display: inline-block">
                                                @csrf
                                                <td><input type="text" id="edit_attendance" name="edit_attendance"
                                                        class="form-control" value="{{ $info->attendance }}"></td>
                                                <td>
                                                    <input type="hidden" id="email" name="email"
                                                        class="form-control" value="{{ $info->email }}">
                                                    <input type="hidden" id="name" name="user_id"
                                                        value="{{ $info->id }}">
                                                    <button type="submit" class="btn btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#edit"
                                                        value="{{ $info->id }}" name="edit_button">Edit</button>
                                            </form>

                                            <form action="{{ route('destroy') }}" method="post"
                                                style="display: inline-block">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" id="name" name="user_id"
                                                    value="{{ $info->id }}">
                                                <input type="hidden" id="email" name="user_email"
                                                    value="{{ $info->email }}">
                                                <input type="hidden" id="attendance" name="user_attendance"
                                                    value="{{ $info->attendance }}">
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>


        <form method="post" action="{{ route('add_attendance') }}">
            @csrf
            {{-- Modal for Add Attendance --}}
            <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Attendance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                onClick="window.location.reload()" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                @foreach ($name as $std)
                                    <div class="form-group">
                                        Full Name
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ $std->full_name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        Email
                                        <input type="hidden" id="name" name="email"
                                            value="{{ $std->email }}">
                                        <input type="email" id="name" name="viewonlyemail"
                                            class="form-control" value="{{ $std->email }}" disabled
                                            style="width: 100%">
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    Attendance Date
                                    <input type="text" id="att_date" name="att_date" class="form-control"
                                        value="{{ $date = date('Y-m-d') }}" disabled>
                                </div>
                                <div class="form-group">
                                    Attendance
                                    <input type="text" id="add_attendance" name="attendance" class="form-control"
                                        value="Present" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

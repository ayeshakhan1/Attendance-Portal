<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
                <table class="table table-striped  table-bordered">
                    @php
                        $sr = 1;
                    @endphp
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Sr no.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Attendance Date</th>
                            <th scope="col">Leave Request</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leave as $get)
                            <tr>
                                <th scope="row">{{ $sr++ }}</th>
                                <td> {{ $get->name }}</td>
                                <td> {{ $get->attendance_date }}</td>
                                <td style="width: 40%"> {{ $get->leave_req }}</td>
                                <td style="width: 10%"> {{ $get->leave_status }}</td>
                                <td>
                                    <form action="{{ route('approved') }}" method="post"
                                        style="display: inline-block">
                                        @csrf
                                        <input type="hidden" id="user_id" name="user_id"
                                            value="{{ $get->id }}">
                                        <input type="hidden" id="name" name="approved" value="Approved">
                                        <button type="submit" class="btn btn-outline-success">Approve</button>
                                    </form>

                                    <form action="{{ route('disapproved') }}" method="post"
                                        style="display: inline-block">
                                        @csrf
                                        <input type="hidden" id="user_id" name="user_id"
                                            value="{{ $get->id }}">
                                        <input type="hidden" id="name" name="disapproved" value="Disapproved">
                                        <button type="submit" class="btn btn-outline-danger">Disapprove</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

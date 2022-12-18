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
                <div class="container">
                    <div class="form-outline text-center" style="width: 200px">
                        <form method="get" action="{{ route('reports') }}">

                            <table class="table">
                                <tbody>
                                    <tr class="text-center">
                                        <th></th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td><input type="search" class="form-control" name="search_field"
                                                placeholder="Search by email..." style="width: 300px"></td>
                                        <td><input type="date" id="startdate" name="start_date" class="form-control"
                                                required /></td>
                                        <td><input type="date" id="enddate" name="end_date" class="form-control"
                                                required />
                                        </td>
                                        <td><button type="submit" class="btn btn-primary"> Search
                                            </button></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    </form>
                    <br><br>
                    <h2>Attendance Report</h2> <br>
                    @if ($check_for_specific_view == true)
                        <br>
                        @foreach ($data as $student)
                            <h4>{{ $student->name }}</h4>
                            <p>{{ $student->email }}</p>
                        @break
                    @endforeach
                    <br><br>
                    <div class="container overflow-auto">
                        <table class="table table-striped">
                            @php
                                $sr = 1;
                            @endphp
                            <thead>
                                <tr>
                                    <th scope="col">Sr no.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $student)
                                    <tr>
                                        <th scope="row">{{ $sr++ }}</th>
                                        <td>{{ $student->attendance_date }}</td>
                                        <td>{{ $student->attendance }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="table table-striped">
                            @php
                                $sr = 1;
                            @endphp
                            <thead>
                                <tr>
                                    <th scope="col">Sr no.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $student)
                                    <tr>
                                        <th scope="row">{{ $sr++ }}</th>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->attendance_date }}</td>
                                        <td>{{ $student->attendance }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                @endif
            </div>
        </div>

    </div>
</div>
</div>

</body>

</html>

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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('userportal') }}">USER ATTENDANCE PORTAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll justify-content-end flex-grow-1 pe-3"
                    style="--bs-scroll-height: 100px;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @foreach ($profile as $profile)
                                <label for="name" style="color: white">{{ $profile->full_name }}</label>
                                <img src="{{ url('/images/' . $profile->profile_pic) }}" width="40" height="40"
                                    class="rounded-circle">
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#updatepic">Update Picture</button></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="text-center" style="padding-top: 50px">
        <h2> Date: &nbsp; {{ $date = date('Y-m-d') }} </h2>
        <br>
        <form method="post" action="{{ route('markattendance') }}">
            @csrf
            <input type="hidden" value="{{ $profile->full_name }}" name="name">
            <input type="hidden" value="{{ $profile->email }}" name="email">

            <input type="hidden" value="Present" name="attendance">
            <input type="hidden" value="{{ $date }}" name="attendance_date">

            <button type="submit" class="btn btn-outline-success" style="width:130px">Mark Attendance</button>
        </form>

        <br>

        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            style="width:130px">
            Mark Leave
        </button>

        <form method="post" action="{{ route('leavereq') }}">
            @csrf
            <input type="hidden" value="{{ $profile->full_name }}" name="name">
            <input type="hidden" value="{{ $profile->email }}" name="email">

            <input type="hidden" value="Leave" name="attendance">
            <input type="hidden" value="{{ $date }}" name="attendance_date">

            {{-- Modal for Leave Request --}}
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Leave Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <textarea class="form-control" id="leave_req" name="leave_req" rows="3" placeholder="Write Leave Request..."
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Send Request</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <br>

        <div class="modal fade modal-fullscreen" id="ViewModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row row-cols-2">
                                <div class="col">
                                    <h4>Date</h4>
                                </div>
                                <div class="col">
                                    <h4>Attendance</h4>
                                </div>
                                <br><br>
                                @foreach ($view as $attendance)
                                    <div class="col">{{ $attendance->attendance_date }}</div>
                                    <div class="col">{{ $attendance->attendance }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ViewModal"
            style="width:130px">View Attendance</button>

        <form method="post" action="{{ route('updatepicture') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $profile->email }}" name="email">
            <div class="modal fade" id="updatepic" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update Profile Picture
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="file" name="profile_image" id="InputProfilePic" class="form-control"
                                    placeholder="Select profile picture" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br><br>
        @if (session()->has('success'))
            <div class="row d-flex justify-content-center">
                <div class="col-md-3 alert alert-success alert-dismissible fade show">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @elseif (session()->has('message'))
            <div class="row d-flex justify-content-center">
                <div class="col-md-3 alert alert-danger alert-dismissible fade show">
                    {{ session()->get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @endforeach
    </div>
</body>

</html>

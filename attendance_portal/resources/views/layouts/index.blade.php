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
    @if (session()->has('email'))
        Session has email
    @endif
    <h1 class="heading-text">Attendance Portal</h1>
    <h4 class="login-text">Login</h4>
    <br>
    {{-- Alert for account created successfully --}}
    @if (session()->has('success'))
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 alert alert-success alert-dismissible fade show">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- Login Form --}}
    <div class="d-flex align-items-center justify-content-center" style="padding-top: 40px;">

        <div class="container" style="margin-top: 10px;">
            {{-- Login tabs --}}
            <ul class="nav nav-tabs d-flex align-items-center justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#students">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#admin">Admin</a>
                </li>
            </ul>
            <div class="d-flex align-items-center justify-content-center">
                {{-- Tab Panes --}}
                <div class="tab-content">
                    <div class="tab-pane container active" id="students">
                        {{-- Students Login --}}
                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" id="InputEmail" name="email" class="form-control"
                                    placeholder="Enter email" required>
                            </div>
                            <div class="form-group" style="padding-bottom: 15px;">
                                <label for="password">Password</label>
                                <input type="password" id="InputPassword" name="password" class="form-control"
                                    placeholder="Enter Password" required>
                                <br>
                                @if (session()->has('message'))
                                    <label class="alert alert-danger">
                                        {{ session()->get('message') }}
                                    </label>
                                @endif
                            </div>
                            <div class="text-center">
                                <small>Doesn't have an account? <a href="{{ route('register') }}">Register</a></small>
                                <br><br>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane container fade" id="admin">
                        {{-- Admin Login --}}
                        <form method="post" action="{{ route('adminlogin') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" id="InputEmail" name="email" class="form-control"
                                    placeholder="Enter email" required>
                            </div>
                            <div class="form-group" style="padding-bottom: 15px;">
                                <label for="password">Password</label>
                                <input type="password" id="InputPassword" name="password" class="form-control"
                                    placeholder="Enter Password" required>
                                <br>
                                @if (session()->has('message'))
                                    <label class="alert alert-danger">
                                        {{ session()->get('message') }}
                                    </label>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>

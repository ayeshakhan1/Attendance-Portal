<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
</head>

<body>
    <h1 class="heading-text">Attendance Portal</h1>
    <h4 class="login-text">Register</h4>
    <br>
    <div class="d-flex align-items-center justify-content-center" style="padding-top: 40px;">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('createaccount') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="InputName" class="form-control" placeholder="Enter Full Name"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="InputEmail" name="email" class="form-control" placeholder="Enter email"
                    required>
                @if (session()->has('alert'))
                    <label style="color: red; display:inline-block">
                        {{ session()->get('alert') }}
                    </label>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="InputPassword" name="password" class="form-control"
                    placeholder="Enter Password (minimum 6 characters)" required>
                @if (session()->has('flash_message'))
                    <label style="color: red; display:inline-block">
                        {{ session()->get('flash_message') }}
                    </label>
                @endif
            </div>
            <div class="form-group" style="padding-bottom: 15px">
                <label for="profilepic">Select Profile Picture</label>
                <input type="file" name="profilepic" id="InputProfilePic" class="form-control"
                    placeholder="Select profile picture" required>
            </div>
            <div class="text-center">
                <small>Already have an account? <a href="{{ route('index') }}">Login</a></small>
                <br><br>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</body>

</html>

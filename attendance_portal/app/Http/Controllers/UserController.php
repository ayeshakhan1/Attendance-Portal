<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Grades;
use App\Models\UserAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // ===== LOGIN PAGE ===== //
    public function index(Request $req)
    {
        if (session()->has('login_data')) {
            return redirect()
                ->route('userportal')
                ->withInput();
        } else {
            return view('layouts.index');
        }
    }

    // ===== LOGIN MODULE ===== //
    public function login(Request $req)
    {
        $login_data = User::where(['email' => $req->email])->first();
        if (!$login_data || !Hash::check($req->password, $login_data->password)) {
            return redirect()
                ->back()
                ->with('message', 'Incorrect email or password!');
        } else {
            $req->session()->put('login_data', $login_data);
            if (session()->has('login_data')) {
                session(['login_data' => $login_data]);
                return redirect()
                    ->route('userportal')
                    ->withInput();
            }
        }
    }

    // ===== LOGOUT MODULE ===== //
    public function logout()
    {
        if (session()->has('login_data')) {
            session()->pull('login_data', null);
        }
        return redirect()->route('index');
    }

    // ===== REGISTERTAION PAGE ===== //
    public function register()
    {
        if (session()->has('login_data')) {
            return redirect()
                ->route('userportal')
                ->withInput();
        } elseif (session()->missing('login_data')) {
            return view('layouts.register');
        }
    }

    // ===== REGISTRATION / CREATE NEW ACCOUNT MODULE ===== //
    // As the new account is created, grades table will also be populated with new user email and name
    public function createaccount(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::select('select id from users WHERE email = "' . $email . '"');

        if (!empty($user)) {
            return back()->with('alert', 'This email is already registered.');
        } else {
            if (strlen($password) < 6) {
                return back()->with('flash_message', 'Password must be greater than 6 characters.');
            } else {
                $data = $request->validate([
                    'name' => 'required',
                    'email' => 'required | email | unique:users,email',
                    'password' => 'required | min:6',
                    'profilepic' => 'required',
                ]);

                $imageName = time() . '.' . $request->profilepic->extension();

                $request->profilepic->move(public_path('images'), $imageName);

                User::create([
                    'full_name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'profile_pic' => $imageName,
                ]);

                $user = DB::select('select id from users WHERE email = "' . $email . '"');
                foreach ($user as $value) {
                    $user_id = $value->id;
                }

                Grades::create([
                    'user_id' => $user_id,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'presents' => 0,
                    'leaves' => 0,
                ]);

                return redirect()
                    ->route('index')
                    ->with('success', 'Account created successfully.');
            }
        }
    }

    // ===== VIEW OF USER ATTENDANCE PORTAL ===== //
    public function userportal(Request $req)
    {
        if (session()->has('login_data')) {
            $email = $req->session()->get('login_data.email');
            $profile = DB::select('SELECT full_name, profile_pic, email from users WHERE email = "' . $email . '"');

            // User attendance view 
            $view = DB::table('users_attendance')
                ->orderBy('attendance_date', 'asc')
                ->where('email', $email)
                ->get();
            return view('layouts.user_panel', compact('profile', 'view'))->with('profile', $profile);
        } else {
            return redirect()->route('index');
        }
    }

    // ===== USER ADDS ATTENDANCE AS PRESENT THROUGH USER PORTAL (BUTTON NAME: Mark Attendance)===== //
    public function markattendance(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $attendance = $request->input('attendance');
        $leave_req = $request->input('leave_req');
        $attendance_date = $request->input('attendance_date');

        $att_date = DB::select('select attendance_date from users_attendance WHERE email = "' . $email . '"');
        $grades = DB::select('select presents from grades WHERE email = "' . $email . '"');
        if (empty($att_date)) {
            $data = ['name' => $name, 'email' => $email, 'attendance' => $attendance, 'leave_req' => $leave_req, 'attendance_date' => $attendance_date, 'leave_status' => ''];
            DB::table('users_attendance')->insert($data);
            DB::table('grades')
                ->where('email', $email)
                ->increment('presents');
            if (!empty($grades)) {
                foreach ($grades as $user) {
                    if ($user->presents == 26) {
                        Grades::where('email', $email)->update([
                            'grades' => 'A',
                        ]);
                    } elseif ($user->presents >= 16 && $user->presents < 26) {
                        Grades::where('email', $email)->update([
                            'grades' => 'B',
                        ]);
                    } elseif ($user->presents >= 10 && $user->presents < 16) {
                        Grades::where('email', $email)->update([
                            'grades' => 'C',
                        ]);
                    } elseif ($user->presents < 10) {
                        Grades::where('email', $email)->update([
                            'grades' => 'D',
                        ]);
                    }
                }
            }
            return redirect()
                ->route('userportal')
                ->with('success', 'Attendance marked successfully.');
        } else {
            foreach ($att_date as $value) {
                if ($value->attendance_date == $attendance_date) {
                    return redirect()
                        ->route('userportal')
                        ->with('message', 'Attendance has already been marked.');
                } else {
                    $data = ['name' => $name, 'email' => $email, 'attendance' => $attendance, 'leave_req' => $leave_req, 'attendance_date' => $attendance_date, 'leave_status' => ''];
                    DB::table('users_attendance')->insert($data);
                    DB::table('grades')
                        ->where('email', $email)
                        ->increment('presents');
                    if (!empty($grades)) {
                        foreach ($grades as $user) {
                            if ($user->presents == 26) {
                                Grades::where('email', $email)->update([
                                    'grades' => 'A',
                                ]);
                            } elseif ($user->presents >= 16 && $user->presents < 26) {
                                Grades::where('email', $email)->update([
                                    'grades' => 'B',
                                ]);
                            } elseif ($user->presents >= 10 && $user->presents < 16) {
                                Grades::where('email', $email)->update([
                                    'grades' => 'C',
                                ]);
                            } elseif ($user->presents < 10) {
                                Grades::where('email', $email)->update([
                                    'grades' => 'D',
                                ]);
                            }
                        }
                    }
                    return redirect()
                        ->route('userportal')
                        ->with('success', 'Attendance marked successfully.');
                }
            }
        }
    }

    // ===== USER SEND LEAVE REQUEST THROUGH USER PORTAL (BUTTON NAME: Mark Leave) ===== //
    // When the user sends leave, his/her attendance will be marked as LEAVE
    public function leavereq(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $attendance = $request->input('attendance');
        $leave_req = $request->input('leave_req');
        $attendance_date = $request->input('attendance_date');

        $att_date = DB::select('select attendance_date from users_attendance WHERE email = "' . $email . '"');
        if (empty($att_date)) {
            $data = ['name' => $name, 'email' => $email, 'attendance' => $attendance, 'leave_req' => $leave_req, 'attendance_date' => $attendance_date, 'leave_status' => ''];
            DB::table('users_attendance')->insert($data);
            DB::table('grades')
                ->where('email', $email)
                ->increment('leaves');
            return redirect()
                ->route('userportal')
                ->with('success', 'Request sent successfully.');
        } else {
            foreach ($att_date as $value) {
                if ($value->attendance_date == $attendance_date) {
                    return redirect()
                        ->route('userportal')
                        ->with('message', 'Attendance has already been marked.');
                } else {
                    $data = ['name' => $name, 'email' => $email, 'attendance' => $attendance, 'leave_req' => $leave_req, 'attendance_date' => $attendance_date, 'leave_status' => ''];
                    DB::table('users_attendance')->insert($data);
                    DB::table('grades')
                        ->where('email', $email)
                        ->increment('leaves');
                    return redirect()
                        ->route('userportal')
                        ->with('success', 'Request sent successfully.');
                }
            }
        }
    }

    // ===== USER UPDATES PROFILE PICTURE ===== //
    public function updatepicture(Request $request)
    {
        $picture = $request->input('profile_image');
        $user_email = $request->input('email');

        // Deleting the previous image in public/images directory
        $profile = DB::select('SELECT profile_pic from users WHERE email = "' . $user_email . '"');
        foreach ($profile as $img) {
            $filename = public_path('images/' . $img->profile_pic);
            if (File::exists($filename)) {
                File::delete($filename);
            }
        }

        // Updating the image
        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('images'), $imageName);

        User::where('email', $user_email)->update([
            'profile_pic' => $imageName,
        ]);

        return redirect()->route('userportal');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Grades;
use App\Models\UserAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ===== LOGIN FORM AUTH ===== //
    public function adminlogin(Request $req)
    {
        $login_data = Admin::where(['email' => $req->email])->first();
        if (!$login_data || !Hash::check($req->password, $login_data->password)) {
            return redirect()
                ->back()
                ->with('message', 'Incorrect email or password!');
        } else {
            $req->session()->put('login_data', $login_data);
            if (session()->has('login_data')) {
                session(['login_data' => $login_data]);
                return redirect()
                    ->route('adminportal')
                    ->withInput();
            }
        }
    }

    // ===== ADMIN PORTAL AFTER SUCCESSFUL LOGIN ===== //
    public function adminportal(Request $req)
    {
        if (session()->has('login_data')) {
            return redirect()
                ->route('adminview')
                ->withInput();
        } else {
            return view('layouts.index');
        }
    }

    // ===== VIEW THE REGISTERED STUDENTS ===== //
    public function adminview()
    {
        $std = DB::select('select full_name, email, profile_pic from users');
        return view('layouts.admin_panel', compact('std'));
    }

    // ===== GET THE STUDENTS DATA AND PASS IT TO ADMIN VIEW ===== //
    public function view_students_record()
    {
        $std = DB::select('select full_name, email, profile_pic from users');

        return redirect()
            ->route('adminportal')
            ->with('std', $std);
    }

    // ===== ADMIN ADD, EDIT, DELETE STUDENTS ATTENDANCE ===== //
    public function admin_manage_attendance(Request $request)
    {
        if (session()->has('login_data')) {
            $email = $request->input('email');

            $att = DB::table('users_attendance')
                ->orderBy('attendance_date', 'asc')
                ->where('email', $email)
                ->get();
            $name = DB::select('select DISTINCT full_name, email from users where email = "' . $email . '"');

            // Search user by email
            foreach ($name as $value) {
                $db_email = $value->email;
            }
            if (empty($name)) {
                session()->flash('flash_message', 'No email found, search again.');
                return view('layouts.admin_manage_attendance', compact('att', 'name'));
            } elseif (!empty($name) && $email == $db_email) {
                session()->pull('flash_message', null);
                return view('layouts.admin_manage_attendance', compact('att', 'name'));
            }
        } else {
            return view('layouts.index');
        }
    }

    // ===== ADMIN ADDS ATTENDANCE ===== //
    public function add_attendance(Request $request)
    {
        $email = $request->input('email');

        $user_data = DB::table('users_attendance')
            ->select('name', 'email', 'attendance_date', 'attendance')
            ->where('email', $email)
            ->get();

        $db_name = DB::select('select DISTINCT full_name from users where email = "' . $email . '"');

        foreach ($db_name as $std_name) {
            $name = $std_name->full_name;
        }
        $attendance = 'Present';
        $attendance_date = date('Y-m-d');
        $leave_req = '';
        $grades = DB::select('select presents from grades WHERE email = "' . $email . '"');

        if ($user_data->isEmpty()) {
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
                ->back()
                ->with('success', 'Attendance marked successfully');
        } else {
            $att_date = DB::table('users_attendance')
                ->orderBy('attendance_date', 'desc')
                ->where('email', $email)
                ->get();

            foreach ($att_date as $value) {
                if ($value->attendance_date == $attendance_date) {
                    return redirect()
                        ->back()
                        ->with('alert', 'Attendance has already been marked.');
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
                    return back()->with('success', $value->attendance_date);
                }
            }
        }
        return back();
    }

    // ===== ADMIN EDITS ATTENDANCE ===== //
    public function edit_attendance(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_attendance = $request->input('edit_attendance');
        $email = $request->input('email');

        UserAttendance::where('id', $user_id)->update([
            'attendance' => $user_attendance,
        ]);
        if ($user_attendance == 'Present' || $user_attendance == 'present') {
            $grades = DB::select('select presents, leaves from grades WHERE email = "' . $email . '"');

            foreach ($grades as $key) {
                if ($key->leaves > 0) {
                    DB::table('grades')
                        ->where('email', $email)
                        ->decrement('leaves');
                }
            }
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
        } elseif ($user_attendance == 'Leave' || $user_attendance == 'leave') {
            $grades = DB::select('select presents, leaves from grades WHERE email = "' . $email . '"');
            foreach ($grades as $key) {
                if ($key->presents > 0) {
                    DB::table('grades')
                        ->where('email', $email)
                        ->decrement('presents');
                }
            }
            DB::table('grades')
                ->where('email', $email)
                ->increment('leaves');
        }
        return back();
    }

    // ===== ADMIN DELETES ATTENDANCE ===== //
    public function destroy(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_email = $request->input('user_email');
        $user_attendance = $request->input('user_attendance');

        $grades = DB::select('select presents, leaves from grades WHERE email = "' . $user_email . '"');

        if ($user_id) {
            UserAttendance::where('id', $user_id)->delete();

            foreach ($grades as $key) {
                if (($key->presents > 0 && $user_attendance == 'Present') || $user_attendance == 'present') {
                    DB::table('grades')
                        ->where('email', $user_email)
                        ->decrement('presents');
                }
                if (($key->leaves > 0 && $user_attendance == 'Leave') || $user_attendance == 'leave') {
                    DB::table('grades')
                        ->where('email', $user_email)
                        ->decrement('leaves');
                }
            }
        }
        return back();
    }

    // ===== VIEW ALL LEAVE REQUESTS ===== //
    public function leave_requests()
    {
        $leave = DB::table('users_attendance')
            ->orderBy('attendance_date', 'asc')
            ->where('attendance', 'Leave')
            ->get();

        return view('layouts.admin_manage_leave_req', compact('leave'));
    }

    // ===== APPROVE LEAVE REQUEST ===== //
    public function approved(Request $request)
    {
        $user_id = $request->input('user_id');
        $status = $request->input('approved');
        UserAttendance::where('id', $user_id)->update([
            'leave_status' => $status,
        ]);
        return back();
    }

    // ===== DISAPPROVE LEAVE REQUEST ===== //
    public function disapproved(Request $request)
    {
        $user_id = $request->input('user_id');
        $status = $request->input('disapproved');
        UserAttendance::where('id', $user_id)->update([
            'leave_status' => $status,
        ]);
        return back();
    }

    // ===== VIEW THE NUMBER OF PRESENTS, LEAVES AND GRADES OF STUDENTS ===== //
    public function grades()
    {
        $grades = DB::select('select * from grades');

        return view('layouts.grades', compact('grades'));
    }

    // ===== VIEW THE REPORTS OF A SPECIFIC STUDENT BY EMAIL OR ALL STUDENTS IN DATE RANGE ===== //
    public function reports(Request $request)
    {
        $s_date = $request->input('start_date');
        $e_date = $request->input('end_date');
        $email = $request->input('search_field');
        $check_for_specific_view = false;

        if (!empty($s_date) && !empty($e_date) && empty($email)) {
            $startDate = Carbon::createFromFormat('Y-m-d', $s_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $e_date);
            $data = UserAttendance::select('name', 'email', 'attendance_date', 'attendance')
                ->whereDate('attendance_date', '>=', $startDate)
                ->whereDate('attendance_date', '<=', $endDate)
                ->orderBy('attendance_date', 'asc')
                ->get();
            return view('layouts.reports', compact('data', 'check_for_specific_view'));
        } elseif (!empty($s_date) && !empty($e_date) && !empty($email)) {
            $check_for_specific_view = true;
            $startDate = Carbon::createFromFormat('Y-m-d', $s_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $e_date);

            $data = UserAttendance::select('name', 'email', 'attendance_date', 'attendance')
                ->whereDate('attendance_date', '>=', $startDate)
                ->whereDate('attendance_date', '<=', $endDate)
                ->where('email', '=', $email)
                ->orderBy('attendance_date', 'asc')
                ->get();
            return view('layouts.reports', compact('data', 'check_for_specific_view'));
        } else {
            $att_date = DB::table('users_attendance')
                ->orderBy('attendance_date', 'asc')
                ->get();

            foreach ($att_date as $key) {
                $from = $key->attendance_date;

                $today = date('Y-m-d');
                $startDate = Carbon::createFromFormat('Y-m-d', $from);
                $endDate = Carbon::createFromFormat('Y-m-d', $today);
                $data = UserAttendance::select('name', 'email', 'attendance_date', 'attendance')
                    ->whereDate('attendance_date', '>=', $startDate)
                    ->whereDate('attendance_date', '<=', $endDate)
                    ->orderBy('attendance_date', 'asc')
                    ->get();
                return view('layouts.reports', compact('data', 'check_for_specific_view'));
            }
        }
    }
}

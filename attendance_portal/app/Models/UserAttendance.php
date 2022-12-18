<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttendance extends Model
{
    use HasFactory;
    protected $table = 'users_attendance';
    protected $fillable = [
        'name',
        'email',
        'attendance',
        'leave_req',
        'attendance_date',
        'leave_status'
    ];
}

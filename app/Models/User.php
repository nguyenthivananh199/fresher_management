<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles ;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function requests()
    {
        return $this->hasMany(Absence_request::class);
    }
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}

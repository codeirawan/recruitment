<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class ApplicantStatus extends Model
{
    public $timestamps = false;
    protected $table = 'applicant_status';

    protected $casts = [
        'at' => 'datetime',
    ];
}

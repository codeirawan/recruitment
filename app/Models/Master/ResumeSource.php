<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeSource extends Model
{
    use SoftDeletes;

    protected $table = 'master_resume_sources';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient_info';
    protected $primaryKey = 'patient_id';

    public function user_patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function degree_program()
    {
        return $this->hasOne(DegreeProgram::class, 'degree_program_id');
    }

    public function religion()
    {
        return $this->hasOne(Religion::class);
    }

    public function town()
    {
        return $this->hasOne(Town::class);
    }

    public function province()
    {
        return $this->hasOne(Province::class);
    }

    public function region()
    {
        return $this->hasOne(Region::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalSchedule extends Model
{
    protected $table = "medical_schedules";

    public function medicalappointment()
    {
        return $this->hasOne(MedicalAppointment::class, 'medical_schedule_id');
    }
}

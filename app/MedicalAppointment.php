<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalAppointment extends Model
{
	protected $table = "medical_appointments";
    public function medicalschedule()
    {
        return $this->belongsTo(MedicalSchedule::class, 'medical_schedule_id');
    }
}

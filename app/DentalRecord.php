<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalRecord extends Model
{
	protected $table = 'dental_records';

	public function dental_appointment()
    {
        return $this->belongsTo(DentalAppointment::class, 'appointment_id');
    }

    public function teeth_info()
    {
        return $this->hasMany(TeethInfo::class, 'condition_id', 'operation_id');
    }
}

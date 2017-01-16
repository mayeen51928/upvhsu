<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalAppointment extends Model
{
    protected $table = 'dental_appointments';

    public function dental_record()
    {
        return $this->hasOne(DentalRecord::class);
    }
}

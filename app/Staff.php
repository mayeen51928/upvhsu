<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff_info';
    protected $primaryKey = 'staff_id';

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

    public function hasDentalSchedules()
    {
        return $this->hasMany(DentalSchedule::class);
    }
}

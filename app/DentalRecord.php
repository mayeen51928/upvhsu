<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalRecord extends Model
{
	protected $table = 'dental_records';
	protected $fillable = ['appointment_id', 'teeth_id', 'condition_id', 'operation_id'];
}

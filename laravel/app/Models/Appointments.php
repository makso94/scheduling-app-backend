<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    public $timestamps = false;

    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointments_has_services', null, 'services_id');
    }
}

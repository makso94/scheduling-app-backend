<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $hidden = ['created_at', 'updated_at', 'pivot'];

    public function appointments()
    {
        return $this->belongsToMany(Appointments::class);
    }
}

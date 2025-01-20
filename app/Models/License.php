<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = ['license_number', 'name', 'vehicle_type', 'issue_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

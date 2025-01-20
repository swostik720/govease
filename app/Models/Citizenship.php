<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizenship extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'name', 'issue_date', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'patient_name',
        'description',
        'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

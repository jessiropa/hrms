<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'position',
        'department_id',
        'user_id',
    ];

    // relasi tabel employe dan deparment yang dimana 1 karyawan memiliki 1 department
    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    // relasi ke tabel penilaian 
    public function performanceAppraisals(): HasMany
    {
        return $this->hasMany(PerformanceAppraisal::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
}
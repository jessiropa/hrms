<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceAppraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'appraisal_date',
        'overall_score',
        'comments',
        'status',
    ];

    protected $casts = [
        'appraisal_date' => 'date',
    ];

    // relasi ke tabel karyawan 
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // relasi ke tabel user untuk menjadi reviewer
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
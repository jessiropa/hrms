<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'start_date' => 'date', // Menggunakan 'date' karena kita hanya butuh tanggal
        'end_date' => 'date',   // Menggunakan 'date'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType() : BelongsTo
    {
            return $this->belongsTo(LeaveType::class);
    }
}
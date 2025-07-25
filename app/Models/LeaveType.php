<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\LeaveRequest;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
        public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
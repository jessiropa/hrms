<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // relasi satu deparment memiliki banyak karyawan 
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
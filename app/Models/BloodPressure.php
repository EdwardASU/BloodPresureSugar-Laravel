<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class BloodPressure extends Model
{
    use HasFactory;

    protected $table = 'blood_pressures';

    // I(mp) systolic + diastolic required; pulse and notes optional
    protected $fillable = ['user_id', 'systolic', 'diastolic', 'pulse', 'recorded_at', 'notes'];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

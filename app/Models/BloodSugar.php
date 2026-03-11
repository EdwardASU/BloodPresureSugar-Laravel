<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class BloodSugar extends Model
{
    use HasFactory;

    protected $table = 'blood_sugars';

    // I(mp) user_id + recorded_at + value are required; notes is optional
    protected $fillable = ['user_id', 'value', 'recorded_at', 'notes'];

    protected $casts = [
        'recorded_at' => 'datetime',
        'value'       => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

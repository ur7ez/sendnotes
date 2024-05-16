<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'send_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

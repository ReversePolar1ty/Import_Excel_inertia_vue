<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'projects';
    protected $with = ['type'];

    protected $casts = [
        'contracted_at' => 'datetime',
        'deadline'=> 'datetime',
        'created_at_time' => 'datetime'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
    protected $fillable = ['user_id', 'log_name', 'description', 'subject_type', 'subject_id', 'properties', 'ip_address'];
    
    // Casts digunakan agar data JSON otomatis diubah menjadi array PHP
    protected $casts = ['properties' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
    public function subject() { return $this->morphTo(); }
}
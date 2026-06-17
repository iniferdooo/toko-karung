<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService {
    public static function log($model, string $action, string $logName) {
        $dirty = $model->getDirty();
        $original = [];
        
        foreach ($dirty as $key => $value) {
            $original[$key] = $model->getOriginal($key);
        }

        ActivityLog::create([
            'user_id' => Auth::id(), // ID User yang sedang login
            'log_name' => $logName,
            'description' => ucfirst($action) . " " . class_basename($model) . " ID: {$model->id}",
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            // Jika di-update, simpan data lama (old) dan data baru (new)
            'properties' => $action === 'updated' ? ['old' => $original, 'new' => $dirty] : $model->toArray(),
            'ip_address' => Request::ip(),
        ]);
    }
}
<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    public static function log(string $action, string $module, string $description, ?Model $subject = null): void
    {
        Activity::create([
            'user_id'      => auth()->id(),
            'action'       => $action,
            'module'       => $module,
            'description'  => $description,
            'subject_id'   => $subject?->id,
            'subject_type' => $subject ? get_class($subject) : null,
        ]);
    }
}

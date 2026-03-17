<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

trait HasAudit
{
    public function recordAudit($action, $model = null, $oldValues = null, $newValues = null)
    {
        AuditLog::create([
            'admin_id' => auth('admin-web')->id(),
            'action' => $action,
            'auditable_type' => $model ? get_class($model) : null,
            'auditable_id' => $model ? $model->id : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
        ]);
    }
}

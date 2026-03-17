@extends('layouts.admin')

@section('page-title', 'System Audit Logs')

@section('content')
<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Admin</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Action</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Model</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">IP Address</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $log->admin->name ?? 'System' }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase;">
                        {{ $log->action }}
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.85rem;">
                    {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}
                </td>
                <td style="padding: 1rem 1.5rem; font-family: monospace;">{{ $log->ip_address }}</td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $log->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $logs->links() }}
</div>
@endsection

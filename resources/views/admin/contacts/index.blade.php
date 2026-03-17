@extends('layouts.admin')

@section('page-title', 'Support Messages')

@section('styles')
<style>
    .message-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s;
    }

    .message-card:hover { transform: translateX(5px); }

    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 0.5rem;
    }

    .sender { font-weight: 600; color: var(--primary-color); }
    .time { font-size: 0.8rem; color: var(--text-muted); }

    .subject { font-weight: 700; margin-bottom: 0.5rem; display: block; }
    .body { color: #4a5568; }
</style>
@endsection

@section('content')
@forelse($contacts as $contact)
<div class="message-card">
    <div class="message-header">
        <div class="sender">{{ $contact->name }} ({{ $contact->email }})</div>
        <div class="time">{{ $contact->created_at->diffForHumans() }}</div>
    </div>
    <div class="message-content">
        <span class="subject">{{ $contact->subject }}</span>
        <p class="body">{{ $contact->message }}</p>
    </div>
</div>
@empty
<p>No messages found.</p>
@endforelse

<div style="margin-top: 2rem;">
    {{ $contacts->links() }}
</div>
@endsection

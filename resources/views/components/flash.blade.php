@php
    $flashClasses = [
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'danger' => 'border-red-200 bg-red-50 text-red-800',
        'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
        'info' => 'border-blue-200 bg-blue-50 text-blue-800',
    ];
@endphp
@foreach (collect(session('flash_notification', [])) as $message)
    <div role="alert" class="mb-6 rounded border px-4 py-3 {{ $flashClasses[$message['level']] ?? $flashClasses['info'] }}">
        {{ $message['message'] }}
    </div>
@endforeach
{{ session()->forget('flash_notification') }}

@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'text-[11px] text-red-600 text-center mb-3'
    ]) }}>
        {{ $status }}
    </div>
@endif
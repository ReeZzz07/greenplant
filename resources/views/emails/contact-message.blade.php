@component('mail::message')
# Новое сообщение с сайта GreenPlant

**Имя:** {{ $messageModel->name }}

**Email:** {{ $messageModel->email }}

@if($messageModel->phone)
**Телефон:** {{ $messageModel->phone }}
@endif

**IP отправителя:** {{ $messageModel->ip_address ?? 'не указано' }}

---

{!! nl2br(e($messageModel->message)) !!}

@component('mail::panel')
Отправлено {{ $messageModel->created_at?->format('d.m.Y H:i') ?? now()->format('d.m.Y H:i') }}
@endcomponent

@component('mail::button', ['url' => route('admin.contact-messages.index')])
Открыть список сообщений
@endcomponent

Спасибо,<br>
{{ config('app.name', 'GreenPlant') }}
@endcomponent


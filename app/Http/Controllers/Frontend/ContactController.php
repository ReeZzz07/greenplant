<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store contact form submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя',
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Укажите корректный email адрес',
            'message.required' => 'Пожалуйста, напишите сообщение',
            'message.min' => 'Сообщение должно содержать минимум 10 символов',
        ]);

        $validated['ip_address'] = $request->ip();

        $messageModel = ContactMessage::create($validated);

        try {
            Mail::to('info@g-plant.ru')->send(new ContactMessageMail($messageModel));
        } catch (\Throwable $e) {
            Log::error('Не удалось отправить письмо из контактной формы: ' . $e->getMessage());
        }

        return redirect()->route('contact')
            ->with('success', 'Спасибо! Ваше сообщение отправлено. Мы свяжемся с вами в ближайшее время.');
    }
}


<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
            'cf-turnstile-response' => 'required|string',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя',
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Укажите корректный email адрес',
            'message.required' => 'Пожалуйста, напишите сообщение',
            'message.min' => 'Сообщение должно содержать минимум 10 символов',
            'cf-turnstile-response.required' => 'Пожалуйста, пройдите проверку безопасности',
        ]);

        // Проверка капчи Cloudflare Turnstile
        $captchaToken = $request->input('cf-turnstile-response');
        if ($captchaToken !== 'no-key' && !$this->verifyTurnstile($captchaToken)) {
            return redirect()->route('contact')
                ->withInput()
                ->withErrors(['cf-turnstile-response' => 'Ошибка проверки безопасности. Пожалуйста, попробуйте еще раз.']);
        }

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

    /**
     * Проверка капчи Cloudflare Turnstile
     */
    private function verifyTurnstile($token)
    {
        // Пропускаем проверку на локальном домене, без ключа или при ошибке 110200
        if ($token === 'localhost' || $token === 'no-key' || $token === 'error-110200') {
            return true;
        }

        $secretKey = \App\Models\Setting::get('cloudflare_turnstile_secret_key', '');
        
        if (empty($secretKey)) {
            // Если ключ не настроен, пропускаем проверку (для разработки)
            return true;
        }

        try {
            $response = Http::timeout(5)->asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();
            return isset($result['success']) && $result['success'] === true;
        } catch (\Exception $e) {
            Log::error('Ошибка проверки Cloudflare Turnstile: ' . $e->getMessage());
            return false;
        }
    }
}


<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order;
        
        return (new MailMessage)
                    ->subject('Новый заказ #' . $order->order_number . ' - GreenPlant')
                    ->greeting('Новый заказ!')
                    ->line('Получен новый заказ №' . $order->order_number)
                    ->line('**Клиент:** ' . $order->customer_name)
                    ->line('**Телефон:** ' . $order->customer_phone)
                    ->line('**Email:** ' . $order->customer_email)
                    ->line('**Сумма заказа:** ' . number_format($order->total_amount, 0, ',', ' ') . ' ₽')
                    ->action('Просмотреть заказ', url('/admin/orders/' . $order->id))
                    ->line('Свяжитесь с клиентом для подтверждения заказа.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
        ];
    }
}


<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationNotification extends Notification
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
        
        $message = (new MailMessage)
                    ->subject('Ваш заказ #' . $order->order_number . ' принят - GreenPlant')
                    ->greeting('Здравствуйте, ' . $order->customer_name . '!')
                    ->line('Спасибо за ваш заказ!')
                    ->line('**Номер заказа:** ' . $order->order_number)
                    ->line('**Сумма:** ' . number_format($order->total_amount, 0, ',', ' ') . ' ₽')
                    ->line('')
                    ->line('**Состав заказа:**');
        
        foreach ($order->items as $item) {
            $subtotal = $item->product_price * $item->quantity;
            $productName = $item->product_name ?? ($item->product ? $item->product->name : 'Товар');
            $message->line('• ' . $productName . ' × ' . $item->quantity . ' шт. — ' . number_format($subtotal, 0, ',', ' ') . ' ₽');
        }
        
        $message->line('')
                ->line('Мы свяжемся с вами в ближайшее время для подтверждения заказа.')
                ->line('По всем вопросам звоните: ' . \App\Models\Setting::get('phone', '+7 (495) 123-45-67'))
                ->line('Спасибо, что выбрали GreenPlant! 🌲');
        
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}


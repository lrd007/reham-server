<?php

namespace Modules\Payment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentFailedMail extends Notification
{
    use Queueable;

    private $name;
    private $amount;
    private $trackid;
    private $paymentid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$amount,$trackid,$paymentid)
    {
        $this->name=$name;
        $this->amount=$amount;
        $this->trackid=$trackid;
        $this->paymentid=$paymentid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        return (new MailMessage)
        ->line(date("F j, Y, g:i a") . '  :تاريخ الفاتورة')
        ->line('مرحبا بكم في ريهام ديفا')
        ->line($this->name . ' مرحبا')
        ->line('عذرا، لقد فشلت عملية الدفع.')
        ->line(' د.ك'  . $this->amount. ' القيمة')
        ->line($this->trackid .'    :رقم التتبع')
        ->line($this->paymentid . '   : رقم العملية')
        ->line('يرجى المحاولة مرة أخرى أو التواصل مع فريق الدعم.')
        ->action('Contact Support', 'https://reham.com/contact-support')
        ->line('Receipt Date:  '.date("F j, Y, g:i a"))
        ->line('Hello '.$this->name)
        ->line('Unfortunately, your payment failed.')
        ->line('Amount:   '.$this->amount.' KWD')
        ->line('Transaction ID:    '.$this->trackid)
        ->line('Payment ID:    '.$this->paymentid)
        ->line('Please try again or contact support for assistance.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

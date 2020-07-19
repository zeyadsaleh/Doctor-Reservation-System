<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;
    protected $appointment;
    protected $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointment, $type)
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $acceptUrl = url('/accept/'.$this->appointment->id);
        $rejectUrl = url('/reject/'.$this->appointment->id);

        return (new MailMessage)
                ->subject('New Appointment')
                ->markdown('emails.confermation', [
                    'appointment' => $this->appointment,
                    'type' => $this->type,
                    'acceptUrl' => $acceptUrl,
                    'rejectUrl' => $rejectUrl
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Appointments\AdminProviderAppointment as ASAppointment;
use App\Models\Appointments\AdminSuperAdminAppointment as APAppointment;
use App\Models\Appointments\ClientProviderAppointment as CPAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentDeclined extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The appointment which was declined.
     *
     * @var App\Models\Appointments\AdminProviderAppointment|App\Models\Appointments\AdminSuperAdminAppointment|App\Models\Appointments\ClientProviderAppointment
     */
    public ASAppointment|APAppointment|CPAppointment $appointment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        ASAppointment|APAppointment|CPAppointment $appointment
    ) {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->line(
                sprintf(
                    'Hi %s, you requested appointment was declined.',
                    $notifiable->name,
                    config('app.name')
                )
            )
            ->line(sprintf('Title: %s', $this->appointment->title))
            ->line(sprintf('Date: %s', $this->appointment->start->format('jS F Y')))
            ->line(
                sprintf(
                    'Timing: %s till %s',
                    $this->appointment->start->format('g:i A'),
                    $this->appointment->end->format('g:i A'),
                )
            )
            ->action('Visit dashboard', route('login'))
            ->line('Thank you for using our application!');
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
            'appointment' => [
                'id' => $this->appointment->id,
                'type' => get_class($this->appointment)
            ],
            'icon' => null,
            'title' => 'Your requested appointment was declined',
            'description' => null,
            'url' => null,
        ];
    }
}

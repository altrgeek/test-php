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
use Illuminate\Support\Carbon;

class AppointmentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The appointment which was requested.
     *
     * @var App\Models\Appointments\AdminProviderAppointment|App\Models\Appointments\AdminSuperAdminAppointment|App\Models\Appointments\ClientProviderAppointment
     */
    public ASAppointment|APAppointment|CPAppointment $appointment;

    /**
     * Create a new notification instance.
     *
     * @param  App\Models\Appointments\AdminProviderAppointment|App\Models\Appointments\AdminSuperAdminAppointment|App\Models\Appointments\ClientProviderAppointment  $appointment
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
            ->line(
                sprintf(
                    'Hi %s, you have received a new appointment, please visit the %s portal to view it.',
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
            ->line(sprintf('Requested By: %s', $this->appointment->requester->name))
            ->action(
                'View appointment',
                route($this->appointment->getShowRouteName($notifiable), $this->appointment->id)
            )
            ->line(sprintf('Thank you for using %s!', config('app.name')));
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
            'title' => 'You have received a new appointment',
            'description' => null,
            'url' => route($this->appointment->getShowRouteName($notifiable), $this->appointment->id),
        ];
    }
}

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

class AppointmentReviewed extends Notification implements ShouldQueue
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
        $message = new MailMessage;

        // If the appointment was requested by the client then add appropriate
        // message to ask them to pay the appointment fee
        if (
            $this->appointment instanceof CPAppointment &&
            $this->appointment->requested_by === 'client' &&
            $notifiable->id === $this->appointment->client->user->id
        )
            $message
                ->line(
                    sprintf(
                        'Hi %s, your requested appointment has been reviewed, please visit the %s portal to pay the appointment fee and continue.',
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
                ->line(sprintf('Fee: %f USD', $this->appointment?->order?->amount ?: 0))
                ->action(
                    'Pay appointment fee',
                    route($this->appointment->getShowRouteName($notifiable), $this->appointment->id)
                );

        else
            $message->line(
                sprintf(
                    'Hi %s, your appointment has been reviewed, please visit the %s portal to continue.',
                    $notifiable->name,
                    config('app.name')
                )
            )
                ->action(
                    'View appointment',
                    route(
                        $this->appointment->getShowRouteName($notifiable),
                        $this->appointment->id
                    )
                );


        return $message
            ->line(sprintf('Thank you for using %s!', config('app.name')));;
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
            'title' => 'Your requested appointment has been reviewed',
            'description' => null,
            'url' => route($this->appointment->getShowRouteName($notifiable), $this->appointment->id),
        ];
    }
}

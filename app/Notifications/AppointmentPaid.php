<?php

namespace App\Notifications;

use App\Models\Appointments\ClientProviderAppointment as Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentPaid extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The appointment that was paid by the client.
     *
     * @var \App\Models\Appointments\ClientProviderAppointment
     */
    protected Appointment $appointment;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Appointments\ClientProviderAppointment
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->appointment->load(['order', 'client']);
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
                    'Hi %s, your client has paid the appointment fee, please visit the %s portal to view it.',
                    $notifiable->name,
                    config('app.name')
                )
            )
            ->line(sprintf('Title: %s', $this->appointment->title))
            ->line(sprintf('Date: %s', $this->appointment->start->format('jS F Y')))
            ->line(sprintf('Client Name: %s', $this->appointment->client->name))
            ->lineIf(
                $this->appointment?->order,
                sprintf('Amount: %f USD', $this->appointment->order?->amount ?: 0)
            )
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
            'title' => 'Your client has paid the appointment fee',
            'description' => null,
            'url' => route($this->appointment->getShowRouteName($notifiable), $this->appointment->id),
        ];
    }
}

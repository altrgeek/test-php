<?php

namespace App\Notifications;

use App\Models\Chat\Message;
use App\Enums\Chat\Chat as ChatType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChatMessageReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The message which was created.
     *
     * @var \App\Models\Chat\Message
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->message->load(['chat', 'user']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        if ($this->message->chat->type === ChatType::GROUP) {
            $name = $this->message->chat->name;
            $icon = $this->message->chat->icon;
        } else {
            $contact = $this->message->chat->participants->firstWhere('id', '!=', $notifiable->id);
            $name = $contact->name;
            $icon = $contact->avatar;
        }

        return [
            'message' => [
                'id' => $this->message->id,
                'type' => $this->message->type,
                'chat' => $this->message->chat->type
            ],
            'icon' => null,
            'title' => sprintf('New message from %s'),
            'description' => $this->message->content,
            'url' => route('dashboard.chat'),
        ];
    }
}

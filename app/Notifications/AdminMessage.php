<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminMessage extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $actionUrl;
    public $actionText;
    public $priority; // 'info', 'success', 'warning', 'error'

    /**
     * Create a new notification instance.
     */
    public function __construct(
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $actionText = null,
        string $priority = 'info'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->priority = $priority;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'action_text' => $this->actionText,
            'priority' => $this->priority,
            'sent_at' => now()->toDateTimeString(),
        ];
    }
}

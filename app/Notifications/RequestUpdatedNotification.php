<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RequestCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Define notification channels
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Store notification in database
     */
    public function toDatabase($notifiable)
    {
        return [
            'title'         => $this->data['title'] ?? 'Request Update',
            'message'       => $this->data['message'] ?? 'Your request has been updated.',
            'reference_no'  => $this->data['reference_no'] ?? null,
            'type'          => 'request',
            'notifiable_id' => $notifiable->id,   // ✅ ensures linked to correct user
        ];
    }

    /**
     * Convert to array (optional, useful for API/broadcasting later)
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}

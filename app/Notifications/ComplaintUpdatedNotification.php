<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ComplaintUpdatedNotification extends Notification implements ShouldQueue
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
            'title'        => $this->data['title'] ?? 'Complaint Update',
            'message'      => $this->data['message'] ?? 'Your complaint has been updated.',
            'reference_no' => $this->data['reference_no'] ?? null,
            'type'         => 'complaint',
            'notifiable_id' => $notifiable->id,  // ✅ ensures correct user
        ];
    }

    /**
     * Convert to array (optional, useful if you add broadcasting/email later)
     */
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}

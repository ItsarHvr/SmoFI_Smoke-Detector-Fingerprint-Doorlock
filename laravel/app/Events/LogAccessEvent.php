<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogAccessEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $updatedLogAccess;
    public $updatePaginate;

    /**
     * Create a new event instance.
     */
    public function __construct($updatedLogAccess, $updatePaginate)
    {
        $this->updatedLogAccess = $updatedLogAccess;
        $this->updatePaginate = $updatePaginate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('log-access-channel')
        ];
    }

    public function broadcastWith()
    {
        return [
            'logAccess' => $this->updatedLogAccess,
            'paginate' => $this->updatePaginate,
        ];
    }
}

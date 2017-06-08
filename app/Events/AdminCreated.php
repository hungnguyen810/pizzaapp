<?php

namespace App\Events;

use App\Models\Admin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminCreated
{
    use InteractsWithSockets, SerializesModels;

    protected $admin;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // Have no idea about this
        // return new PrivateChannel('channel-name');
    }

    /**
     * Get admin
     *
     * @return \App\Models\Admin
     */
    public function getAdmin() {
        return $this->admin;
    }
}

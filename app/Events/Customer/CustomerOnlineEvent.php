<?php

namespace App\Events\Customer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerOnlineEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $onlineCustomers;

    public function __construct($onlineCustomers)
    {
        $this->onlineCustomers = $onlineCustomers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    public function broadcastOn()
    {
        return new Channel('online-customers');
    }
    public function broadcastAs()
    {
        return 'CustomerOnlineEvent';
    }
    
}

<?php

namespace App\Events\Customer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $customer;
    public $unReadnotifications;

    public function __construct($unReadnotifications, $customer)
    {
        $this->unReadnotifications = $unReadnotifications;
        $this->customer = $customer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('customers.'. $this->customer->id);
    }

    public function broadcastAs()
    {
        return 'CustomerNotificationEvent';
    }
    
    public function broadcastWith()
    {
        return [
            'notifications' => $this->unReadnotifications
        ];
    }
}

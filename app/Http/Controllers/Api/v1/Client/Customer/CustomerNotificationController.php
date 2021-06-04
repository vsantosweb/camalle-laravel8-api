<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerNotificationController extends Controller
{
    public function index()
    {

        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC');

        $result = isset(request()->paginate) ? $notifications->paginate(request()->paginate) : $notifications->get();

        return $this->outputJSON($result, '', false);
    }

    public function unread()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->where('read_at', NULL);

        $result = isset(request()->paginate) ? $notifications->paginate(request()->paginate) : $notifications->get();

        return $this->outputJSON($result, '', false);
    }

    public function read($id)
    {
        $notification = auth()->user()->notifications->find($id);
        $notification->read_at = now();
        $notification->save();
        return $this->outputJSON($notification, '', false);
    }

    public function readAll()
    {
        $notifications = auth()->user()->notifications();

        $notifications->where('read_at', NULL)->update([
            'read_at' => now()
        ]);

        return $this->outputJSON(auth()->user()->notifications, '', false);
    }
}

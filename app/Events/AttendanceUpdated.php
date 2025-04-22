<?php


namespace App\Events;

use App\Models\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;


use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Ganti dari ShouldBroadcast

class AttendanceUpdated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function broadcastOn()
    {
        return new Channel('attendance-channel');
    }

    public function broadcastAs()
    {
        Log::info('AttendanceUpdated event fired', ['attendance' => $this->attendance]);
        return 'attendance.updated';
    }

}


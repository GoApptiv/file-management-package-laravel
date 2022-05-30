<?php

namespace GoApptiv\FileManagement\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmFileVariant
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }
}

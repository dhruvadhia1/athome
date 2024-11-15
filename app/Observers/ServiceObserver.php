<?php

namespace App\Observers;

use App\Models\Service;
use App\Models\ServiceApproval;

class ServiceObserver
{
    public function created(Service $service)
    {
        ServiceApproval::create([
            'service_id' => $service->id,
            'status' => 'pending'
        ]);
    }
}

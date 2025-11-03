<?php

namespace App\MyVendor;

use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\PendingActivityLog;

class MyPendingActivityLog extends PendingActivityLog
{
    public function school_id($id): static
    {
        /** @var MyActivityLogger $logger */
        $logger = $this->logger;
        $logger->school_id($id);
        return $this;
    }

    public function level($level): static
    {
        /** @var MyActivityLogger $logger */
        $logger = $this->logger;
        $logger->level($level);
        return $this;
    }
}

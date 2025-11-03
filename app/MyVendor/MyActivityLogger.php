<?php

namespace App\MyVendor;

use Spatie\Activitylog\ActivityLogger;

class MyActivityLogger extends ActivityLogger
{
        public function school_id($id)
        {
            $this->activity->school_id = $id;
            return $this;
        }

        public function level($level)
        {
            $this->activity->level = $level;
            return $this;
        }
}

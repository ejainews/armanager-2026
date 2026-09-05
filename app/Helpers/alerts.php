<?php

# Flash Alert Success Message
function alert_success($message)
{
    session()->flash('alert-success', '<i class="fa fa-check"></i> ' .$message);
}

# Flash Alert Warning Message
function alert_warning($message)
{
    session()->flash('alert-warning', '<i class="fa fa-exclamation-triangle"></i> ' .$message);
}

# Flash Alert Danger Message
function alert_danger($message)
{
    session()->flash('alert-danger', '<i class="fa fa-exclamation-circle"></i> ' . $message);
}

# Flash Alert INfo Message
function alert_info($message)
{
    session()->flash('alert-info', '<i class="fa fa-info-circle"></i> ' . $message);
}
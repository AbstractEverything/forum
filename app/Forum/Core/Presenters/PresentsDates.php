<?php

namespace App\Forum\Core\Presenters;

use Carbon\Carbon;

trait PresentsDates
{
    /**
     * Format the difference between now() and the created_at attribute for humans
     * @return string
     */
    public function createdAgo()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffForHumans();
    }

    /**
     * Format the difference between now() and the updated_at atttribute for humans
     * @return string
     */
    public function updatedAgo()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->diffForHumans();
    }

    /**
     * Format created_at attribute to display only the date
     * @return string
     */
    public function dateOnly()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->toFormattedDateString();
    }
}
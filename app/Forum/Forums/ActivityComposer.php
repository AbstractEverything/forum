<?php

namespace App\Forum\Forums;

use Activity;
use Illuminate\Contracts\View\View;

class ActivityComposer
{
    /**
     * Bind data to the view.
     * @param  View  $view
     * @return null
     */
    public function compose(View $view)
    {
        $view->with([
            'activity' => Activity::users(config('forum.last_online_minutes'))->get(),
            'guestsCount' => Activity::guests()->count(),
        ]);
    }
}
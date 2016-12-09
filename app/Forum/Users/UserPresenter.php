<?php

namespace App\Forum\Users;

use App\Forum\Core\Presenters\PresentsDates;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    use PresentsDates;

    /**
     * Concat the full name and last name
     * @return string
     */
    public function fullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Combine the post and replies count
     * @return integer
     */
    public function postsAndRepliesCount()
    {
        return $this->postsCount + $this->repliesCount;
    }
}
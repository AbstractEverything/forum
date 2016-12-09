<?php

namespace App\Forum\Replies;

use App\Forum\Core\Presenters\PresentsDates;
use Laracasts\Presenter\Presenter;
use Michelf\Markdown;

class ReplyPresenter extends Presenter
{
    use PresentsDates;

    /**
     * Transform the body attribute to markdown
     * @return string
     */
    public function markdownBody()
    {
        return Markdown::defaultTransform($this->body);
    }
}
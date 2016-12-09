<?php

namespace App\Forum\Forums;

use App\Forum\Core\Presenters\PresentsDates;
use Carbon\Carbon;
use Laracasts\Presenter\Presenter;
use Michelf\Markdown;

class ForumPresenter extends Presenter
{
    use PresentsDates;
}
<?php

namespace App\Forum\Core\Quotes;

use App\Forum\Users\User;
use Illuminate\Database\Eloquent\Model;

interface Quoteable
{
    /**
     * Convert a model into a quote string
     * @param  integer $id
     * @return string
     */
    public function convert($id);
}
<?php

namespace App\Forum\Core\Quotes;

use App\Forum\Core\Quotes\Quoteable;

class NullQuote implements Quoteable
{
    /**
     * Default to an empty string
     * @param  integer $id
     * @return string
     */
    public function convert($id)
    {
        return '';
    }
}
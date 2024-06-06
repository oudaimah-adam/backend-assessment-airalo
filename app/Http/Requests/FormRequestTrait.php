<?php

declare(strict_types=1);

namespace App\Http\Requests;

trait FormRequestTrait
{
    /**
     * @return string[]
     */
    public function validDateTimeFormats(): array
    {
        return [
            'Y-m-d',
            'Y-m-d H:i',
            'Y-m-d H:i:s',
            'Y-m-d\TH:i:sP',
        ];
    }
}

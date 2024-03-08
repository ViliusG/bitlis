<?php

namespace App\Services;

use App\Models\ShortURL;

class ShortUrlService
{
    public function create(array $request)
    {
        return ShortUrl::create($request);
    }
}

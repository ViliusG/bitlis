<?php

namespace App\Services;

use App\Models\ShortURL;

class ShortUrlService
{
    public function create(array $request)
    {
        return ShortUrl::create($request);
    }

    public function deleteById($id): void
    {
        ShortUrl::findOrFail($id)->delete();
    }
}

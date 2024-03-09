<?php

namespace App\Services;

use App\Models\ShortURL;

class RedirectService
{
    public function getLink(string $key): string
    {
        return ShortUrl::where('short_url', $key)
            ->where('expires_at', '>', now())
            ->firstOrFail()
            ->original_url;
    }
}

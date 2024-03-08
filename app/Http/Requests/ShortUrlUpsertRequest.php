<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShortUrlUpsertRequest extends FormRequest
{
    public function getUserId():int
    {
        return $this->input('userId');
    }

    public function getOriginalUrl():string
    {
        return $this->input('originalUrl');
    }

    public function getShortUrl():string
    {
        return $this->input('shortUrl');
    }

    public function getExpiresAt(): Carbon
    {
        $expiresAt = $this->input('expireInDays') ?? config('urls.default_expiry_time');

        return Carbon::now()->addDays($expiresAt);
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'originalUrl' => 'required|url|max:2048',
            'shortUrl' => [
                'string',
                'max:255',
                Rule::unique('short_urls', 'short_url'),
                Rule::unique('reserved_urls', 'reserved_url')
            ],
            'expiresAt' => 'date|after:now',
        ];
    }

    public function toCreateArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'original_url' => $this->getOriginalUrl(),
            'short_url' => $this->getShortUrl(),
            'expires_at' => $this->getExpiresAt()
        ];
    }
}

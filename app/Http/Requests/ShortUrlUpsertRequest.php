<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
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
        return $this->input('shortUrl') ?? Str::random(Config::get('urls.random_url_length'));
    }

    public function getExpiresAt(): Carbon
    {
        $expiresAt = $this->input('expireInDays') ?? Config::get('urls.default_expiry_time');

        return Carbon::now()->addDays($expiresAt);
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'originalUrl' => 'required|url|max:2048',
            'shortUrl' => [
                'string',
                'alpha_num',
                'max:255',
                Rule::unique('short_urls', 'short_url'),
                Rule::unique('reserved_urls', 'reserved_url')
            ],
            'expireInDays' => 'int|min:1',
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

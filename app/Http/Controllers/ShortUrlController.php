<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlUpsertRequest;
use App\Services\ShortUrlService;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlController extends BaseController
{
    public function __construct(public readonly ShortUrlService $shortUrlService)
    {}

    public function store(ShortUrlUpsertRequest $request): Response
    {
        $shortUrl = $this->shortUrlService->create($request->toCreateArray());

        return response()->json([
            'id' => $shortUrl->id,
            'userId' => $shortUrl->user_id,
            'originalUrl' => $shortUrl->original_url,
            'shortUrl' => Str::finish(Config::get('app.url'), '/') . $shortUrl->short_url,
            'expiryDate' => Carbon::parse($shortUrl->expires_at)->format('Y-m-d'),
        ]);
    }

    public function destroy($id): Response
    {
        $this->shortUrlService->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

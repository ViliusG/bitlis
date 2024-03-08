<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlUpsertRequest;
use App\Services\ShortUrlService;
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
            'originalUrl' => $shortUrl->original_url,
            'shortUrl' => Str::finish(Config::get('app.url'), '/') . $shortUrl->short_url,
            'expiryDate' => $shortUrl->expires_at
        ]);
    }

    public function destroy($id): Response
    {
        $this->shortUrlService->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

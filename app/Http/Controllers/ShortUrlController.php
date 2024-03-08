<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlUpsertRequest;
use App\Models\ShortURL;
use App\Services\ShortUrlService;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlController extends BaseController
{
    public function __construct(public readonly ShortUrlService $shortUrlService)
    {}

    public function store(ShortUrlUpsertRequest $request): ShortURL
    {
        return $this->shortUrlService->create($request->toCreateArray());
    }

    public function destroy($id): Response
    {
        $this->shortUrlService->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

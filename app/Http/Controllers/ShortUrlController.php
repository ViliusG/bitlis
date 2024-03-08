<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlUpsertRequest;
use App\Services\ShortUrlService;
use Illuminate\Routing\Controller as BaseController;

class ShortUrlController extends BaseController
{
    public function __construct(public readonly ShortUrlService $shortUrlService)
    {}

    public function store(ShortUrlUpsertRequest $request)
    {
        return $this->shortUrlService->create($request->toCreateArray());
    }
}

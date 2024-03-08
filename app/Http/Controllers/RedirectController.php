<?php

namespace App\Http\Controllers;

use App\Services\RedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class RedirectController extends BaseController
{
    public function __construct(public readonly RedirectService $redirectService)
    {
    }
    public function redirect($key): RedirectResponse
    {
        return redirect()->to($this->redirectService->getLink($key));
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json(
        bool $success = true,
        int $code = Response::HTTP_OK,
        mixed $data = [],
        string $message = '',
    ): JsonResponse {
        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }
}

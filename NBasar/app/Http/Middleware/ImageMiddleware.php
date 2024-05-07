<?php

namespace App\Http\Middleware;

use App\Actions\GetErrorAction;
use App\Exceptions\AppException;
use App\Exceptions\ExceptionTypes;
use App\Models\Estate;
use App\Services\ErrorCheckService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ImageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $errorCheck = new ErrorCheckService(ExceptionTypes::ImageException);
  
        if (!Auth::guard('sanctum')->check())
        throw new AppException(GetErrorAction::AccessDenied());

        
        $errorCheck->checkIfExisting(new Estate,
           $request->route('uuid') ? $request->route('uuid') : $request->input('uuid'),
        'Uuid');

        return $next($request);
    }
}

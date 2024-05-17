<?php

namespace App\Http\Middleware;

use App\Actions\GetErrorAction;
use App\Exceptions\AppException;
use App\Exceptions\ExceptionTypes;
use App\Models\User;
use App\Services\ErrorCheckService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $errorCheck = new ErrorCheckService(ExceptionTypes::UserException);

        if ($request->isMethod('patch') || $request->isMethod('delete')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());
            
            if (isset($request->id)) 
                $errorCheck->checkIfExisting(new User, $request->id);
            
        }

        return $next($request);
    }
}

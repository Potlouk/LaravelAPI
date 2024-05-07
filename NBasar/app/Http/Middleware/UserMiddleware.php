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

        if ($request->isMethod('patch')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());
            
            $errorCheck->checkIfExisting(new User, $request->input('id'));
            
            if (User::findById(Auth::guard('sanctum')->user()->id)->hasRole('Admin'))  
                return $next($request);

            $errorCheck->checkIfMatching($request->input('id'), Auth::guard('sanctum')->user()->id, 'id');
        }

        if ($request->isMethod('delete')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());
            
            $errorCheck->checkIfExisting(new User, $request->route('id'));
            
            if (User::findById(Auth::guard('sanctum')->user()->id)->hasRole('Admin'))  
                return $next($request);

            $errorCheck->checkIfMatching($request->id, Auth::guard('sanctum')->user()->id, 'id');
        }

        return $next($request);
    }
}

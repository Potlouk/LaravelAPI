<?php

namespace App\Http\Middleware;

use App\Actions\GetErrorAction;
use App\Exceptions\AppException;
use App\Exceptions\ExceptionTypes;
use App\Models\Estate;
use App\Models\User;
use App\Services\ErrorCheckService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EstateMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $errorCheck = new ErrorCheckService(ExceptionTypes::EstateException);
        
        if ($request->isMethod('patch') || $request->isMethod('post')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());

            $errorCheck->checkIfExisting(new Estate,$request->route('uuid'),'Uuid');
            
             if (User::findById(Auth::guard('sanctum')->user())->hasRole('Admin'))  
                return $next($request);

            $errorCheck->checkIfMatching(Estate::findByUuid($request->route('uuid'))->user_id, Auth::guard('sanctum')->user()->id,'uuid');    
        }

        if ($request->isMethod('delete')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());
            
            $errorCheck->checkIfExisting(new Estate,$request->route('uuid'),'Uuid');
            
            if (User::findById(Auth::guard('sanctum')->user())->hasRole('Admin'))  
                return $next($request);

            $errorCheck->checkIfMatching(Estate::findByUuid($request->route('uuid'))->user_id, Auth::guard('sanctum')->user()->id,'uuid');    
        }

        return $next($request);
    }
}

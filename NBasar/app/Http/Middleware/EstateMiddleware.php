<?php

namespace App\Http\Middleware;

use App\Actions\GetErrorAction;
use App\Exceptions\AppException;
use App\Exceptions\ExceptionTypes;
use App\Models\RealEstate;
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
        
        if ($request->isMethod('patch') || $request->isMethod('delete')) {
            if (!Auth::guard('sanctum')->check())
                throw new AppException(GetErrorAction::AccessDenied());

            $errorCheck->checkIfExisting(new RealEstate,$request->route('uuid'),'Uuid');
            $errorCheck->checkIfMatching(RealEstate::findByUuid($request->route('uuid'))->user_id, Auth::guard('sanctum')->user()->id,'uuid');    
            
        }

        return $next($request);
    }
}

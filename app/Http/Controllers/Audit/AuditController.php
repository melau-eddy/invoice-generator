<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Service\AuditService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class Audit Controller
 */
class AuditController extends Controller
{

    /**
     * @param AuditService $auditService
     */
    public function __construct(protected AuditService $auditService){

    }

    /**
     * Retrieves the activity log of specific user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAudit()
    {
        try{
            $user_id = Auth::user()->id;
            $audits=$this->auditService->findAllBy('user_id', $user_id);
            return view('Audit.ShowAudits', compact('audits'))->with('status', 'Activity log');
        }
        catch (\Exception $exception){
            Log::error($exception);
            return Redirect::back()->withErrors(['error_msg', $exception]);
        }

    }
}

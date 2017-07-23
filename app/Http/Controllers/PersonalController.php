<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recurrence;
use App\PriorityLevel;
use App\Http\Requests\PersonalRequest;
use App\Services\PersonalSaveService;
use App\Services\InviteService;

class PersonalController extends Controller
{

    protected $personalService;

    public function __construct(PersonalSaveService $personalService, InviteService $inviteService)
    {
        $this->personalService = $personalService;
        $this->inviteService = $inviteService;
    }

    public function personal()
    {
        $data['recurrence'] = Recurrence::all();
        $data['priority_level'] = PriorityLevel::all();
        return view('personal.create-personal', $data);
    }

    public function create(PersonalRequest $request)
    {
        if ($createdId = $this->personalService->create($request)) {
            return redirect('/personal/' . $createdId)->with('message', 'Personal Plan Created');
        }
        return redirect()->back()->with('error', 'Error Creating Personal Plan');
    }

    public function index($personal_id)
    {
        $data['plan_details'] = $this->personalService->getPlan($personal_id);
        return view('personal.personal', $data);
    }

    public function invites()
    {
        if ($data['allInvites'] = $this->inviteService->getAllInvites()) {
            return view('personal.view-invites', $data);
        } else {
            return redirect()->back()->with('error', 'Error Retrieving Invites');
        }
    }

    public function invites_response(Request $request)
    {
        dd($request);
        if ($response = $this->inviteService->inviteResponse($request)) {
            if ($response == 'accepted'): return redirect('/dashboard')->with('message', 'Invitation Accepted');
            elseif ($response == 'rejected'): return redirect('/dashboard')->with('messsage', 'Invitation Rejected');
            else: return redirect()->back()->with('error', 'Error Processing Invitation');
            endif;
        }
    }
}

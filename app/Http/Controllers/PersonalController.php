<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recurrence;
use App\PriorityLevel;
use App\Http\Requests\PersonalRequest;
use App\Services\PersonalSaveService;
use App\Services\InviteService;
use App\Services\AnnouncementService;

class PersonalController extends Controller
{
    protected $personalService;
    protected $inviteService;
    protected $announcementService;

    public function __construct(
        PersonalSaveService $personalService,
        InviteService $inviteService,
        AnnouncementService $announcementService
    )
    {
        $this->personalService = $personalService;
        $this->inviteService = $inviteService;
        $this->announcementService = $announcementService;
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
        if ($data['plan_details'] = $this->personalService->getPlan($personal_id)) {
            return view('personal.personal', $data);
        }
        return abort(404);
    }

}

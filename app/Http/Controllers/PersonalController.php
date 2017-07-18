<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recurrence;
use App\PriorityLevel;
use App\Http\Requests\PersonalRequest;
use App\Services\PersonalSaveService;

class PersonalController extends Controller
{

    protected $personalService;

    public function __construct(PersonalSaveService $personalService)
    {
        $this->personalService = $personalService;
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
}

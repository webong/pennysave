<?php

namespace App\Services;

use App\PersonalSave;
use Auth;

class PersonalSaveService {

    public function __construct(PersonalSave $personalSave)
    {
        $this->personalSave = $personalSave;
    }

    public function create($request)
    {
        $uuid = gen_uuid();
        $this->personalSave->id = $uuid;
        $this->personalSave->user_id = Auth::user()->id;
        $this->personalSave->name = $request->name;
        $this->personalSave->target_amount = $request->target_amount;
        $this->personalSave->instalment_amount = $request->instalment_amount;
        $this->personalSave->priority_level = $request->priority;
        $this->personalSave->recurrence = $request->recurrence;
        $this->personalSave->start_date = $request->start_date;
        $this->personalSave->target_date = $request->target_date;
        if ($this->personalSave->save()) {
            return $uuid;
        }
        return false;
    }

    public function getPlan($personal_id)
    {
        return $this->personalSave::where('id', $personal_id)->first();
    }

    public function getAllPlans()
    {
        return $this->personalSave::all();
    }

    public function calculateTargetDate()
    {

    }

    public function calculateInstalmentAmount()
    {

    }

}

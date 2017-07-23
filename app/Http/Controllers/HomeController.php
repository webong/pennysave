<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;
use App\Services\SavingsRecordService;
use App\Services\InviteService;

class HomeController extends Controller
{

    protected $homeService;
    protected $savingsRecordsService;
    protected $inviteService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        HomeService $homeService, 
        SavingsRecordService $savingsRecordsService,
        InviteService $inviteService
    )
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
        $this->savingsRecordsService = $savingsRecordsService;
        $this->inviteService = $inviteService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['checkInvites'] = $this->inviteService->checkInvites();
        $data['user'] = $this->homeService->home();
        // $data['savings'] = $this->savingsRecordsService->total_currently_saved($savingsPlanId);
        // dd($data);
        return view('home', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;
use App\Services\SavingsRecordService;

class HomeController extends Controller
{

    protected $homeService;

    protected $savingsRecordsService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $homeService, SavingsRecordService $savingsRecordsService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
        $this->savingsRecordsService = $savingsRecordsService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = $this->homeService->home();
        // $data['savings'] = $this->savingsRecordsService->total_currently_saved($savingsPlanId);
        return view('home', $data);
    }
}

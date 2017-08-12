<?php

namespace App\Services;

use App\Announcement;
use App\AnnounceUser;
use Auth;
use App\Services\TeamServices;

class AnnouncementService
{

    protected $paginator = 20;
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function create($team_id, $request)
    {
        $announce = new Announcement;
        $announce_id = gen_uuid();
        $announce->id = $announce_id;
        $announce->subject = $request->subject;
        $announce->announcer = Auth::user()->id;
        $announce->content = $request->content;
        if ($announce->save()) {
            $members = $this->teamService->getAllTeamMembers($team_id);
            foreach ($members as $member) {
                $announce_user = new AnnounceUser;
                $announce->announce_id = $announce_id;
                $announce->team_id = $team_id;
                $announce->user_id = $member->id;
                $announce->status = ($member->id == Auth::user()->id) ? true : false;
            }
            return $announce_id;
        }
        return false;
    }

    public function getAllPlatformAnnouncements()
    {
        return Announcement::whereHas('announce_user', function($query) {
            $query->where('team_id', null)
                ->orWhere('team_id', 'etibeNG')
                ->where('user_id', Auth::user()->id);
        })->get();
    }
    
    public function getAllTeamAnnouncements($team_id)
    {
        return Announcement::whereHas('announce_user', function($query) use ($team_id) {
            $query->where('team_id', $team_id)
                ->where('user_id', Auth::user()->id);
        })->get();
    }

    public function getUnreadTeamAnnouncements($team_id)
    {
        return Announcement::whereHas('announce_user', function($query) use ($team_id) {
            $query->where('team_id', $team_id)
                ->where('user_id', Auth::user()->id)
                ->where('status', false);
        })->take(3)->get();
    }

    public function getUnreadOtherAnnouncements($team_id)
    {
        return Announcement::whereHas('announce_user', function($query) {
            $query->where('team_id', null)
                ->orWhere('team_id', 'etibeNG')
                ->where('user_id', Auth::user()->id)
                ->where('status', false);
        })->take(3)->get();
    }

    public function getAllUnreadAnnouncements()
    {
        return Announcement::whereHas('announce_user', function($query) {
            $query->where('user_id', Auth::user()->id)
                ->where('status', false);
        })->get();
    }

    public function getAnnouncementById($announcement_id)
    {
        return Announcement::where('id', $announcement_id)
            ->select('subject', 'content')
            ->first();
    }

    public function getAnnouncementContent($announcement_id)
    {
        return Announcement::where('id', $announcement_id)
            ->select('content')
            ->first();
    }

    public function updateAnnouncementStatus($announce_id, $team_id = NULL)
    {
        $update = AnnounceUser::where('announce_id', $announcement_id)
            ->where('team_id', $team_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($update) $update->status = ($update->status) ? false : true;
        if ($update->save()) return true;
        return false;
    }
}
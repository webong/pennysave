<?php

namespace App\Services;

use App\Announcement;
use Auth;

class AnnouncementService
{

    protected $paginator = 20;

    public function create($team_id, $request)
    {
        $announce = new Announcement;
        $announce_id = gen_uuid();
        $announce->id = $announce_id;
        $announce->subject = $request->subject;
        $announce->content = $request->content;
        $announce->team_id = $team_id;
        if ($announce->save()) {
            return $announce_id;
        }
        return false;
    }

    public function getAllAnnouncements()
    {
        return Announcement::where('status', 'Like', Auth::user()->id)
            ->with('team', 'user')
            ->get();
    }

    public function getAllTeamAnnouncements($team_id)
    {
        return Announcement::where('team_id', $team_id)
            ->with('team')
            ->paginate($this->paginator);
    }

    public function getUnreadAnnouncements($team_id)
    {
        return Announcement::where('team_id', $team_id)
            ->where('status', 'Like', Auth::user()->id)
            ->get();
    }

    public function getAnnouncementById($team_id, $announcement_id)
    {
        return Announcement::where('id', $announcement_id)
            ->where('team_id', $team_id)
            ->first();
    }

    public function getAnnouncementContent($team_id, $announcement_id)
    {
        return Announcement::where('id', $announcement_id)
            ->where('team_id', $team_id)
            ->select('content')
            ->first();
    }

    public function mark_as_seen($team_id, $id)
    {
        $announce = $this->getAnnouncementById($team_id, $id);
        if ($announce) {
            $announce->status = $announce->status . ',' . Auth::user()->id; 
            return true;
        }
        return false;
    }
}
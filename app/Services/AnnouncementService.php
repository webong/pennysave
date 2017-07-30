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

    }

    public function getAllAnnouncements($team_id)
    {
        return Announcement::where('team_id', $team_id)
            ->paginate($this->paginator);
    }

    public function getUnreadAnnouncements($team_id)
    {
        return Announcement::where('team_id', $team_id)
            ->whereNotIn(Auth::user()->id, 'read')
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
        return false
    }
}
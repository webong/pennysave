<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnnouncementService;
use Illuminate\Http\Requests\AnnouncementRequest;

class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function createAnnouncement($team_id, AnnouncementRequest $request)
    {
        if ($this->announcementService->create($team_id, $request)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function mark_as_seen($team, $id)
    {
        if ($this->announcementService->mark_as_seen($team_id, $id)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function getAllAnnouncements($team_id)
    {
        return $this->announcementService->getAllAnnouncements($team_id);
    }

    public function getAllUnread($team_id)
    {
        return $this->announcementService->getUnreadAnnouncements($team_id);
    }

    public function getAnnouncementById($team_id, $announce_id)
    {
        return $this->announcementService->getAnnouncementById($team_id, $announce_id);
    }

    public function getAnnouncementContent($team_id, $announce_id)
    {
        return $this->announcementService->getAnnouncementContent($team_id, $announce_id);
    }
}

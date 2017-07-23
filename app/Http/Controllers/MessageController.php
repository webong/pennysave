<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\MessageRef;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Group;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\HandleMessageAttachments;
use App\Services\MessageService;

class MessageController extends Controller
{

    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index($team_id)
    {
        if ($data = $this->messageService->index($team_id)) {
            return view('message.index', $data);
        } else {
            return abort();
        }
    }

    public function create($team_id)
    {
        if ($data = $this->messageService->create($team_id)) {
            return view('message.compose', $data);
        } else {
            return abort();
        }
    }

    public function send($team_id, MessageRequest $request)
    {
        if ($data = $this->messageService->send($team_id, $request)) {
            if ($data = 'sent') {
                return redirect('/teams/' . $team_id . '/messages/sent')
                    ->with(['message' => 'Message Sent Successfully']);
            } else {
                return redirect('/teams/' . $team_id . '/messages/draft')
                    ->with(['message' => 'Draft Message Saved Successfully']);
            }
        } else {
            return redirect()->back()->with(['error' => 'Failed To Send Message']);
        }
    }

    public function read($team_id, $type = null, $id)
    {
        if ($data = $this->messageService->read($team_id, $type, $id)) {
            dd($data);
            return view('message.read', $data);
        } else {
            return abort();
        }
    }

    public function draft($team_id)
    {
        if ($data = $this->messageService->draft($team_id)) {
            return view('message.draft', $data);
        } else {
            return abort();
        }
    }

    public function trash($team_id)
    {
        if ($data = $this->messageService->trash($team_id)) {
            return view('message.trash', $data);
        } else {
            return abort();
        }
    }

    public function sent($team_id)
    {
        if ($data = $this->messageService->sent($team_id)) {
            return view('message.sent', $data);
        } else {
            return abort();
        }
    }

    public function reply($team_id, $type, $id)
    {
        if ($data = $this->messageService->reply($team_id, $type, $id)) {
            return view('message.compose', $data);
        } else {
            return abort();
        }
    }

    public function forward($team_id, $type, $id) {
        if ($data = $this->messageService->create($team_id, $type, $id)) {
            return view('message.compose', $data);
        } else {
            return abort();
        }
    }

    public function delete($team_id, $type = null, $id)
    {
        if ($data = $this->messageService->create($team_id, $type, $id)) {
            return redirect()->route('messages.trash', ['team_id' => $team_id])
                ->with('message', 'Message was successfully moved to trash');
        } else {
            return redirect()->back()
                ->with('error', 'Error moving message to trash');
        }
    }

    public function restore($team_id, $id)
    {
        if ($this->messageService->restore($team_id, $id)) {
            return redirect('/teams/{{$team_id}}/messages')
                ->with('message', 'Message Restored');
        } else {
            return redirect()->back()
                ->with('message', 'Message Restored');
        }
    }

    public function deleteMultiple($team_id, Request $request)
    {
        if (count($request->select_for_delete) > 1) {
            $success = 'Messages successfully moved to trash'; 
            $error = 'Error moving messages to trash'; 
        } else {
            $success = 'Message successfully moved to trash'; 
            $error = 'Error moving message to trash'; 
        }
        if ($this->messageService->deleteMultiple($team_id, $request)) {
            return redirect()->with('message', $message);
        }
        return redirect()->back()->with('error', $error);
    }
}

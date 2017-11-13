<?php

namespace App\Services;

use App\Services\UserService;
use App\MessageRef;
use App\Message;
use Auth;
use App\User;
use App\Group;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\HandleMessageAttachments;

class MessageService
{

    use HandleMessageAttachments;

    protected $userService;
    protected $messageRef;
    protected $paginate;
    
    public function __construct(UserService $userService, Messageref $messageRef)
    {
        $this->userService = $userService;
        $this->messageRef = $messageRef;
        $this->paginate = 20;
    }

    public function index($team_id)
    {
        $data['team_id'] = $team_id;
        $data['unread'] = $this->getUnreadCount($team_id);
        $data['type'] = 'inbox';
        $data['messages'] = DB::table('message_refs')
            ->join('messages', 'message_refs.message_id', '=', 'messages.id')
            ->join('users as recipient', 'message_refs.receiver', '=', 'recipient.id')
            ->where('message_refs.receiver', Auth::user()->id)
            ->where('message_refs.team_id', $team_id)
            ->join('users as sender', 'message_refs.sender', '=', 'sender.id')
            ->orderBy('message_refs.created_at', 'desc')
            ->distinct()
            // ->groupBy('message_refs.message_id')
            ->simplePaginate($this->paginate, ['messages.*', 'message_refs.*']); 
            // The second value is to ensure paginate returns correct total value as found here:
            // https://stackoverflow.com/questions/41283083/distinct-with-pagination-in-laravel-5-2-not-working
        return $data;
    }

    public function create($team_id, $everyone)
    {
        if ($everyone) $data['everyone'] = true;
        $data['team_id'] = $team_id;
        $data['unread'] = $this->getUnreadCount($team_id);
        $data['users'] = $this->userService->getUsersIDAndName($team_id);

        return $data;
    }

    public function send($team_id, MessageRequest $request)
    {
        if ($message_id = $this->createNewMessage($request)) {
            if ($request->has('receivers')) {
                foreach($request->receivers as $receiver) {
                    if ($response = $this->createNewReference($request, $receiver, $message_id, $team_id)) {
                        continue;
                    }
                }
                return $response;
            // If Message doesn't have receivers, it's draft
            } else {
                return $this->createDraftReference($request, $receiver = null, $message_id, $team_id);
            }
        } else {
            return false;
        }
    }

    public function read($team_id, $type = null, $id)
    {
        $data['team_id'] = $team_id;
        $determine = ($type == 'read') ? 'receiver' : 'sender';
        $update = ($type == 'read') ? 
            MessageRef::where('message_id', $id)
            ->update([$determine . '_status' => 2]) : 
            false;
        $data['message'] = DB::table('message_refs')
            ->join('messages', 'message_refs.message_id', '=', 'messages.id')
            ->join('users as recipient', 'message_refs.' . $determine, '=', 'recipient.id')
            ->where('message_refs.' . $determine, Auth::user()->id)
            ->where('message_refs.team_id', $team_id)
            ->join('users as sender', 'message_refs.sender', '=', 'sender.id')
            ->where('messages.id', $id)
            ->select('messages.*', 'message_refs.*', DB::raw('concat(sender.first_name, " ", sender.last_name) as sender_name'),
              DB::raw('concat(recipient.first_name, " ", recipient.last_name) as recipient_name'))
            ->first();
        $data['unread'] = $this->getUnreadCount($team_id);
        $data['type'] = $type;
        $getParticular = MessageRef::where('message_id', $id)->where($determine, Auth::user()->id)->first();
        $data['prev'] = MessageRef::where('created_at', '<', $getParticular->created_at)->max('created_at');
        $data['next'] = MessageRef::where('created_at', '>', $getParticular->created_at)->min('created_at');
        return $data;
    }

    public function draft($team_id)
    {
        $data['team_id'] = $team_id;
        $data['type'] = 'draft';
        $data['unread'] = \App\MessageRef::where('receiver', Auth::user()->id)
            ->where('receiver_status', 1)
            ->where('team_id', $team_id)
            ->count();
        $data['messages'] = $this->getMessages($team_id, $type = 'sent', $status_value = 2);
        return $data;
    }

    public function trash($team_id)
    {
        $data['team_id'] = $team_id;
        $data['type'] = 'trash';
        $data['unread'] = \App\MessageRef::where('receiver', Auth::user()->id)
            ->where('receiver_status', 1)
            ->where('team_id', $team_id)
            ->count();
        $data['messages'] = DB::table('message_refs')
            ->join('messages', 'message_refs.message_id', '=', 'messages.id')
            ->join('users', 'message_refs.sender', '=', 'users.id')
            ->where('message_refs.sender', Auth::user()->id)
            ->orWhere('message_refs.receiver', Auth::user()->id)
            ->where('message_refs.sender_status', 5)
            ->where('message_refs.receiver_status', 5)
            ->where('team_id', $team_id)
            ->orderBy('message_refs.created_at', 'desc')
            ->simplePaginate($this->paginate);
        return $data;
    }

    public function sent($team_id)
    {
        $data['team_id'] = $team_id;
        $data['type'] = 'sent';
        $data['unread'] = \App\MessageRef::where('receiver', Auth::user()->id)
            ->where('receiver_status', 1)
            ->where('team_id', $team_id)
            ->count();
        $data['messages'] = $this->getMessages($team_id, $type = 'sent', $status_value = 1);
        return $data;
    }

    public function reply($team_id, $type, $id)
    {
        $data['team_id'] = $team_id;
        $data['unread'] = $this->getUnreadCount($team_id);
        $data['users'] = $this->userService->getUsersIDAndName($team_id);
        $data['message'] = $this->getFirstMessage($type, $team_id, $id);
        $data['type'] = 'reply';
        $data['receivers'] = $this->usersRelatedToMessage($team_id, $id, $type);
        return $data;
    }

    public function forward($team_id, $type, $id) 
    {
        $data['team_id'] = $team_id;
        $data['unread'] = $this->getUnreadCount($team_id);
        $data['users'] = $this->userService->getUsersIDAndName($team_id);
        $data['message'] = $this->getFirstMessage($type, $team_id, $id);
        $data['type'] = 'forward';
        return $data;
    }

    public function delete($team_id, $type = null, $id)
    {
        $determine = ($type == 'sent' || $type == 'draft') ? 'sender' : 'receiver';
        if ($type == 'trash') {
            return MessageRef::where('message_id', $id)
                ->where('sender', Auth::user()->id)
                ->orWhere('receiver', Auth::user()->id)
                ->where('team_id', $team_id)
                ->where('team_id', $team_id)
                ->delete();
        }
        return $messageref = MessageRef::where('message_id', $id)
            ->where($determine, Auth::user()->id)
            ->where('team_id', $team_id)
            ->update([$determine . '_status' => 5,
                'status' => ($type) ? $type : 'unread'
            ]);
    }

    public function restore($team_id, $id)
    {
        $determineType = DB::table('message_refs')
            ->where('receiver', Auth::user()->id)
            ->where('team_id', $team_id)
            ->where('message_id', $id)
            ->first();
        if ($determineType) {
            $determineType->receiver_status = ($determineType->status == 'read') ? 2 : 1;
            $determineType->status = null;
            return ($determineType->save()) ? true : false;
        } else {
            $determineType = DB::table('message_refs')
                ->where('sender', Auth::user()->id)
                ->where('team_id', $team_id)
                ->where('message_id', $id)
                ->first();
            if ($determineType) {
                $determineType->sender_status = ($determineType->status == 'sent') ? 1 : 2;
                $determineType->status = null;
                return ($determineType->save()) ? true : false;
            }
        }
    }

    public function usersRelatedToMessage($team_id, $message_id, $type)
    {
        $determine = ($type == 'receive') ? 'sender' : 'receiver';
        return DB::table('message_refs')
            ->join('users', 'message_refs.' . $determine, '=', 'users.id')
            ->where('message_refs.message_id', $message_id)
            ->where('message_refs.team_id', $team_id)
            ->select('users.id', DB::raw('concat(users.first_name," ", users.last_name) as name'))
            ->get();
        
    }

    public function getMessages($team_id, $type, $status_value)
    {
        $determine = ($type == 'sent'  || $type == 'draft') ? 'sender' : 'receiver';
        return DB::table('message_refs')
            ->join('messages', 'message_refs.message_id', '=', 'messages.id')
            ->join('users', 'message_refs.' . $determine, '=', 'users.id')
            ->where('message_refs.' . $determine, Auth::user()->id)
            ->where('message_refs.' . $determine . '_status', $status_value)
            ->where('team_id', $team_id)
            ->orderBy('message_refs.created_at', 'desc')
            ->distinct()
            // ->groupBy('message_refs.message_id')
            ->simplePaginate($this->paginate, ['messages.*', 'message_refs.*']);
    }

    public function getFirstMessage($type, $team_id, $id)
    {
        $determine = ($type == 'sent'  || $type == 'draft') ? 'sender' : 'receiver';
        return DB::table('message_refs')
            ->join('messages', 'message_refs.message_id', '=', 'messages.id')
            ->join('users', 'message_refs.' . $determine, '=', 'users.id')
            ->where('message_refs.' . $determine, Auth::user()->id)
            ->where('team_id', $team_id)
            ->where('message_id', $id)
            ->first();
    }

    public function getNewMessages()
    {
        return $this->messageRef->where('receiver', Auth::user()->id)
            ->where('receiver_status', 1)
            ->with('team')->get();
    }

    public function getUnreadCount($team_id)
    {
        return $this->messageRef->where('receiver', Auth::user()->id)
            ->where('receiver_status', 1)
            ->where('team_id', $team_id)
            ->count();
    }

    public function createNewMessage($request)
    {
        $message = new Message;
        $message_id = gen_uuid();
        $message->id = $message_id;
        $message->subject = $request->subject;
        $message->content = $request->message;
        $message->brief_content = read_more(strip_tags($request->message));
        return ($message->save()) ? $message_id : false;
    }

    public function createNewReference($request, $receiver, $message_id, $team_id)
    {
        if ($request->has('mailMessageSubmit') && $request->mailMessageSubmit == 'submitMail') {
            return $this->createSentReference($request, $receiver, $message_id, $team_id);
        } else {
            return $this->createDraftReference($request, $receiver, $message_id, $team_id);
        }
    }

    public function createSentReference($request, $receiver, $message_id, $team_id)
    {
        $message_ref_id = gen_uuid();
        $messageRef = new MessageRef;
        $messageRef->id = $message_ref_id;
        $messageRef->message_id = $message_id;
        $messageRef->team_id = $team_id;
        $messageRef->sender = Auth::user()->id;
        $messageRef->receiver = $receiver;
        $messageRef->sender_status = 1; // Sent Message
        $messageRef->receiver_status = 1;
        $messageRef->attachments_csv = $this->handleAttachments($request);
        return ($messageRef->save()) ? 'sent' : false;
    }

    public function createDraftReference($request, $receiver, $message_id, $team_id)
    {
        $message_ref_id = gen_uuid();
        $messageRef = new MessageRef;
        $messageRef->id = $message_ref_id;
        $messageRef->message_id = $message_id;
        $messageRef->team_id = $team_id;
        $messageRef->sender = Auth::user()->id;
        $messageRef->receiver = $receiver;
        $messageRef->sender_status = 2; // Draft Message
        $messageRef->receiver_status = 1;
        $messageRef->attachments_csv = $this->handleAttachments($request);
        return ($messageRef->save()) ? 'draft' : false;
    }

    public function deleteMultiple($team_id, Request $request, $type)
    {
        foreach ($request->select_for_delete as $intended) {
            $status = ($this->messageService->delete($team_id, $type, $intended))
                ? true : false;
        }
        return $status;
    }    

}
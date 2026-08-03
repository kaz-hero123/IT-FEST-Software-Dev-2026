<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function getMessages(Request $request)
    {
        $sessionId = $request->query('session_id', 'default_session');

        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($messages->isEmpty()) {
            $welcome = ChatMessage::create([
                'session_id'  => $sessionId,
                'sender_name' => 'Rara',
                'sender_type' => 'admin',
                'message'     => 'Halo! 👋 Saya Rara dari tim Admin Jelajah Madura. Ada yang bisa saya bantu terkait pertanyaan atau destinasi Anda?',
            ]);
            $messages = collect([$welcome]);
        }

        $formatted = $messages->map(function ($msg) {
            return [
                'id'          => $msg->id,
                'sender'      => $msg->sender_type,
                'sender_name' => $msg->sender_name,
                'text'        => $msg->message,
                'time'        => $msg->created_at->format('H:i'),
            ];
        });

        return response()->json([
            'status'   => 'success',
            'messages' => $formatted,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id'  => 'required|string',
            'sender_name' => 'required|string',
            'sender_type' => 'required|in:user,admin',
            'message'     => 'required|string',
        ]);

        $senderType = $request->sender_type;
        $senderName = $request->sender_name;

        // Security check: Only real admins can send as admin
        if ($senderType === 'admin') {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized admin impersonation.'
                ], 403);
            }
        }

        $msg = ChatMessage::create([
            'session_id'  => $request->session_id,
            'sender_name' => $senderName,
            'sender_type' => $senderType,
            'message'     => trim($request->message),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => [
                'id'          => $msg->id,
                'sender'      => $msg->sender_type,
                'sender_name' => $msg->sender_name,
                'text'        => $msg->message,
                'time'        => $msg->created_at->format('H:i'),
            ],
        ]);
    }

    public function getAdminConversations()
    {
        $sessions = ChatMessage::select('session_id')
            ->distinct()
            ->get()
            ->pluck('session_id');

        $conversations = [];

        foreach ($sessions as $index => $sId) {
            $msgs = ChatMessage::where('session_id', $sId)
                ->orderBy('created_at', 'asc')
                ->get();

            $lastMsg = $msgs->last();
            $firstUserMsg = $msgs->where('sender_type', 'user')->first();
            $userName = $firstUserMsg ? $firstUserMsg->sender_name : $sId;

            $formatted = $msgs->map(function ($m) {
                return [
                    'id'          => $m->id,
                    'sender'      => $m->sender_type,
                    'sender_name' => $m->sender_name,
                    'text'        => $m->message,
                    'time'        => $m->created_at->format('H:i'),
                ];
            })->values();

            $userUnread = 0;
            foreach ($msgs->reverse() as $m) {
                if ($m->sender_type === 'user') {
                    $userUnread++;
                } else {
                    break;
                }
            }

            $conversations[] = [
                'id'          => $sId,
                'sessionId'   => $sId,
                'userName'    => $userName,
                'lastTime'    => $lastMsg ? $lastMsg->created_at->format('H:i') : '',
                'lastMessage' => $lastMsg ? $lastMsg->message : '',
                'lastSender'  => $lastMsg ? $lastMsg->sender_type : null,
                'lastMsgId'   => $lastMsg ? $lastMsg->id : null,
                'unreadCount' => $userUnread,
                'messages'    => $formatted,
            ];
        }

        return response()->json([
            'status'        => 'success',
            'conversations' => $conversations,
        ]);
    }

    public function clearMessages(Request $request)
    {
        $sessionId = $request->input('session_id');
        if ($sessionId) {
            ChatMessage::where('session_id', $sessionId)->delete();

            ChatMessage::create([
                'session_id'  => $sessionId,
                'sender_name' => 'Rara',
                'sender_type' => 'admin',
                'message'     => 'Halo! Sesi percakapan telah diperbarui. Ada yang bisa Rara bantu?',
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}

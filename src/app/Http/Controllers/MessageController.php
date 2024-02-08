<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(int $userId, MessageService $messageService): JsonResponse
    {
        return response()->json($messageService->listByUserIds($userId, Auth::id()));
    }

    public function store(MessageRequest $request, MessageService $messageService): JsonResponse
    {
        $data = $request->validated();

        $message = $messageService->store(Auth::id(), $data['receiver_id'], $data['message']);

        return response()->json(['data' => $message]);
    }
}

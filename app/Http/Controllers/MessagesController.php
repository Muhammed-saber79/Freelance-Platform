<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        $sender = Auth::user();
        $receiver = User::find(13);
        return view('messages', compact('sender', 'receiver'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'receiver_id' => ['required', 'int', 'exists:users,id']
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->post('receiver_id'),
            'message' => $request->post('message'),
        ]);

        event(new MessageCreated($message));

        return response()->json($message, 201);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

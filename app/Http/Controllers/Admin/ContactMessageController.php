<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of messages
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display the specified message
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Remove the specified message
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Сообщение удалено');
    }

    /**
     * Toggle read status
     */
    public function toggleRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => !$contactMessage->is_read]);

        return response()->json([
            'success' => true,
            'is_read' => $contactMessage->is_read
        ]);
    }
}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Mail\PasswordResetMail;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'phone' => 'nullable|max:20',
            'category' => 'nullable|string|max:255',
        ]);

        Contact::create([
            'name' => $request->name,
            'customer_id' => auth()->user() ? auth()->user()->id : null,
            'surname' => $request->surname,
            'email' => $request->email,
            'message' => $request->message,
            'phone' => $request->phone,
            'category' => $request->category,
        ]);

        $data = $request->only(['name', 'surname', 'email', 'phone', 'category', 'message']);

        Mail::to('info@brendoo.com')->queue(new ContactMail($data));

        return response()->json(['message' => 'Successfully added']);
    }

}

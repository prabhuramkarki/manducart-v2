<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'issue' => 'required',
            'message' => 'required',
        ]);

        Contact::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'issue' => $request->issue,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Message sent successfully!',
        ], 201);
    }
}

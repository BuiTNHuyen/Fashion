<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::orderByDesc('created_at')->paginate(20);
        return view('admin.contact.index', compact('contacts'));
    }
} 
<?php

// app/Http/Controllers/FeedbackController.php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        Feedback::create($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback submitted successfully.');
    }

    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }
}

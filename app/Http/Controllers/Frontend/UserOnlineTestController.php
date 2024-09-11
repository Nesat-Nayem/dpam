<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class UserOnlineTestController extends Controller
{
    public function index()
    {
        // Fake data for the quiz
        $questions = [
            [
                'question' => 'What is the capital of France?',
                'options' => ['London', 'Berlin', 'Paris', 'Madrid', 'Rome'],
                'correct_answer' => 'Paris'
            ],
            // Add more questions here
        ];

        // return view('dashboard.online-test', compact('questions'));
        return view('frontend.dashboard.online-test.index', compact('questions'));
    }


    public function submit(Request $request)
    {
        $userAnswers = $request->input('answers');
        $questions = $this->getQuestions(); // Method to get questions (replace with database query later)

        $score = 0;
        $total = count($questions);

        foreach ($questions as $index => $question) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] === $question['correct_answer']) {
                $score++;
            }
        }

        return view('frontend.dashboard.online-test.test-results', compact('score', 'total'));
    }


    private function getQuestions()
    {
        // Fake data (replace with database query later)
        return [
            [
                'question' => 'What is the capital of France?',
                'options' => ['London', 'Berlin', 'Paris', 'Madrid', 'Rome'],
                'correct_answer' => 'Paris'
            ],
            // Add more questions here
        ];
    }


}

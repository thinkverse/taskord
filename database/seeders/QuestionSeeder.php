<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Public Question
        $question = Question::factory()->create([
            'user_id'     => 1,
            'title'       => 'Hello, World this is public question!',
            'body'        => 'Hello, World!',
            'patron_only' => false,
        ]);

        $question->tag('Facebook');
        $question->tag('Twitter');
        $question->tag('Google');
        $question->tag('Taskord');
        $question->tag('GitLab');
        $question->tag('GitHub');

        // Patron Only Question
        Question::factory()->create([
            'user_id'     => 1,
            'title'       => 'Hello, World this is patron only question!',
            'body'        => 'Hello, World!',
            'patron_only' => true,
        ]);

        Question::factory()->count(48)->create();
    }
}

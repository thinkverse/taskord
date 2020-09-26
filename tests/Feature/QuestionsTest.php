<?php

namespace Tests\Feature;

use Tests\TestCase;

class QuestionsTest extends TestCase
{
    public function test_questions_newest_url()
    {
        $response = $this->get(route('questions.newest'));

        $response->assertStatus(200);
    }

    public function test_questions_newest_displays_the_questions_newest_page()
    {
        $response = $this->get(route('questions.newest'));

        $response->assertStatus(200);
        $response->assertViewIs('question.newest');
    }

    public function test_unanswered_newest_url()
    {
        $response = $this->get(route('questions.unanswered'));

        $response->assertStatus(200);
    }

    public function test_questions_unanswered_displays_the_questions_unanswered_page()
    {
        $response = $this->get(route('questions.unanswered'));

        $response->assertStatus(200);
        $response->assertViewIs('question.unanswered');
    }

    public function test_popular_newest_url()
    {
        $response = $this->get(route('questions.popular'));

        $response->assertStatus(200);
    }

    public function test_questions_popular_displays_the_questions_popular_page()
    {
        $response = $this->get(route('questions.popular'));

        $response->assertStatus(200);
        $response->assertViewIs('question.popular');
    }
}

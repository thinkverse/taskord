<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class QuestionCreated extends PointType
{
    public $points = 20;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}

<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class TaskCompleted extends PointType
{
    public $allowDuplicates = false;

    public $points = 1;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}

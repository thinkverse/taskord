<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class GoalReached extends PointType
{
    public $allowDuplicates = false;

    public function __construct($subject, $award)
    {
        $this->subject = $subject;
        $this->award = $award;
    }

    public function getPoints()
    {
        return $this->award;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}

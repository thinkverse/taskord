<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class CommentCreated extends PointType
{
    public $points = 5;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function payee()
    {
        return $this->getSubject()->user;
    }
}

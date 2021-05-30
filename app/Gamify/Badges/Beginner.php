<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Beginner extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 0;
    }
}

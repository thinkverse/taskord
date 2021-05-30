<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Intermediate extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 2500;
    }
}

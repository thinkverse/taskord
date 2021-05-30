<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Professional extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 5000;
    }
}

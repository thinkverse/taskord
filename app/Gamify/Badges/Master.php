<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Master extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 10000;
    }
}

<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Enlightened extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 50000;
    }
}

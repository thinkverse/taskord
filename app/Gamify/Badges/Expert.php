<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Expert extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 7500;
    }
}

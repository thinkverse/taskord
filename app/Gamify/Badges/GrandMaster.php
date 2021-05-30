<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class GrandMaster extends BadgeType
{
    protected $description = '';

    public function qualifier($user)
    {
        return $user->getPoints() >= 20000;
    }
}

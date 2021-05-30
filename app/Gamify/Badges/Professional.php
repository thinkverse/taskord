<?php

namespace App\Gamify\Badges;

use App\Models\User;
use QCod\Gamify\BadgeType;

class Professional extends BadgeType
{
    /**
     * Description for badge.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Check is user qualifies for badge.
     *
     * @param $user
     *
     * @return bool
     */
    public function qualifier(User $user)
    {
        return $user->getPoints() >= 5000;
    }
}

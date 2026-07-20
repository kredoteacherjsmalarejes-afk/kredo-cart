<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

abstract class Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

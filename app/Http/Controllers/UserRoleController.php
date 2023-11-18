<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    //
    public function getRoleUser(){
        $userRole = Role::all()->User;
        // $userRole = UserRole::all();
        return $userRole;
    }   
}

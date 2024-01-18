<?php

namespace App\Http\Traits;

use App\Providers\RouteServiceProvider;

trait AuthTrait{
    public function chekGuard($request){
        if($request->type == 'student'){
            $guradName = "student";
        }
        else if($request->type == 'teacher'){
            $guradName = "teacher";
        }
        else if($request->type == 'parent'){
            $guradName = "parent";
        }else{
            $guradName = "web";

        }
        return $guradName;
    }
    // -===================================================
    public function redirect($request){

        if($request->type == 'student'){
            return redirect()->intended(RouteServiceProvider::STUDENT);
        }
        elseif ($request->type == 'parent'){
            return redirect()->intended(RouteServiceProvider::PARENT);
        }
        elseif ($request->type == 'teacher'){
            return redirect()->intended(RouteServiceProvider::TEACHER);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Employer;
use App\Models\Loan;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    public function redirect()
    {
        $now=Carbon::now()->getTimestamp();

        $pending=Loan::where('progress',2)->get();
        $active=Loan::where('progress',3)->where('dueDate','>',$now)->get();
        $due=Loan::where('progress',3)->where('dueDate','<',$now)->get();

        return Inertia::render('Dashboard',[
            'pending'   =>  $pending,
            'active'    =>  $active,
            'due'       =>  $due,
        ]);
    }

    public function index()
    {

        $users=User::orderBy('firstName','ASC')->where('id','!=',Auth::id())->get();

        return Inertia::render('Users/Index',[
            'users'=>UserResource::collection($users),
        ]);

    }

    public function show($id)
    {
        $user=User::find($id);

        if(is_object($user)){

            $loans=$user->loans()->where('progress','>',1)->orderBy('appliedDate','DESC')->get();

            return Inertia::render('Users/Show',[
               '_user'=>$user,
               'loans'=> $loans
            ]);

        }else
            return Redirect::route('dashboard')->with('error','Invalid user');

    }



}

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

    public function employerSelect(Request $request)
    {
        Validator::make($request->all(), [
            'employerId' => ['required', 'integer']
        ])->validate();

        $user=User::find(Auth::id());
        $employer=Employer::find($request->employerId);
        $errors=[];

        if (is_object($employer)){
            $employee=$employer->employees()->where('nationalId',$user->nationalId)->first();
            if(is_object($employee)){
                $user->update([
                    'employer_id'=>$employer->id
                ]);

//                return Inertia::render('Dashboard');
                return Redirect::route('dashboard');

            }else{
                array_push($errors,'You are not registered under this employer');
                return Redirect::back()->with('error','You are not registered under this employer');
            }
        }else{
            array_push($errors,'The employer does not exist');
            return Redirect::back()->with('error','The employer does not exist');

        }

//        return Redirect::back(302)->with('error',$errors);
//        return Inertia::render('Dashboard',[
//            'errors'=>$errors,s
//            'employers'=>Employer::all(),
//        ]);
    }

    public function guarantorDashboardView()
    {
        return Inertia::render('Guarantor/Dashboard');
    }
}

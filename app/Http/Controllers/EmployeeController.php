<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function create($id)
    {
        $employer=Employer::find($id);
        if (is_object($employer)){

            return Inertia::render('Employee/New',[
                'employer'=>$employer
            ]);

        }else
            return Redirect::route('dashboard')->with('error','Invalid Employer');


    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'photo'                => ['required'],
            'firstName'            => ['required'],
            'lastName'             => ['required'],
            'phoneNumberMobile'    => ['required'],
            'phoneNumberWork'      => ['required'],
            'position'             => ['required'],
            'email'                => ['required'],
            'physicalAddress'      => ['required'],
            'workAddress'          => ['required'],
            'nationalId'           => ['required','min:8'],
            'contractDuration'     => ['required'],
            'employer_id'          => ['required'],
        ])->validate();

        $employee = new Employee([
            'photo'                => $request->photo,
            'firstName'            => $request->firstName,
            'middleName'           => $request->middleName,
            'lastName'             => $request->lastName,
            'phoneNumberMobile'    => $request->phoneNumberMobile,
            'phoneNumberWork'      => $request->phoneNumberWork,
            'position'             => $request->position,
            'email'                => $request->email,
            'physicalAddress'      => json_encode($request->physicalAddress),
            'workAddress'          => json_encode($request->workAddress),
            'nationalId'           => strtoupper($request->nationalId),
            'contractDuration'     => $request->contractDuration,
            'employer_id'          => $request->employer_id,
        ]);

        $employee->save();

        return Redirect::route('employer.show',['id'=>$employee->employer_id]);
    }
}

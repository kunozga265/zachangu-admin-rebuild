<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Http\Resources\EmployersResource;

class EmployerController extends Controller
{
    public function index()
    {
        $employers=Employer::all();

        return Inertia::render('Employers/Index',[
            'employers'=>EmployersResource::collection($employers)
        ]);
    }

    public function show($id)
    {
        $employer=Employer::find($id);
        if (is_object($employer)){

            $employees=$employer->employees;
            foreach($employees as $employee){
                $employee->contractDuration=date('jS F, Y',$employee->contractDuration);
                $employee->physicalAddress=json_decode($employee->physicalAddress);
                $employee->workAddress=json_decode($employee->workAddress);
            }


            return Inertia::render('Employers/Show',[
               'employer'   => $employer,
               'employees'  => $employees
            ]);

        }else
            return Redirect::route('dashboard')->with('error','Invalid Employer');
    }

    public function create()
    {
        return Inertia::render('Employers/New');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'                      => ['required'],
            'physicalAddressName'       => ['required'],
            'physicalAddressBox'        => ['required'],
            'physicalAddressLocation'   => ['required'],
            'proxyName'                 => ['required'],
            'proxyEmail'                => ['required','email'],
            'proxyPhoneNumber'          => ['required'],
            'letter'                    => ['required'],
            'email'                     => ['required','email'],
        ])->validate();

        $employer=Employer::create([
            'name'                      =>$request->name,
            'physicalAddressName'       =>$request->physicalAddressName,
            'physicalAddressBox'        =>$request->physicalAddressBox,
            'physicalAddressLocation'   =>$request->physicalAddressLocation,
            'proxyName'                 =>$request->proxyName,
            'proxyEmail'                =>$request->proxyEmail,
            'proxyPhoneNumber'          =>$request->proxyPhoneNumber,
            'letter'                    =>$request->letter,
            'email'                     =>$request->email,
        ]);
        $employer->save();

        return Redirect::route('employer.show',['id'=>$employer->id]);
//        return Inertia::render('')

    }

    public function edit($id)
    {
        $employer=Employer::find($id);

        if(is_object($employer)){
            return Inertia::render('Employers/Edit',[
                'employer'=>$employer
            ]);

        }else
            return Redirect::back()->with('error','Invalid employer');

    }

    public function update(Request $request,$id)
    {
        Validator::make($request->all(), [
            'name'                      => ['required'],
            'physicalAddressName'       => ['required'],
            'physicalAddressBox'        => ['required'],
            'physicalAddressLocation'   => ['required'],
            'proxyName'                 => ['required'],
            'proxyEmail'                => ['required','email'],
            'proxyPhoneNumber'          => ['required'],
            'letter'                    => ['required'],
            'email'                     => ['required','email'],
        ])->validate();

        $employer=Employer::find($id);

        if(is_object($employer)){
            $employer->update([
                'name'                      =>$request->name,
                'physicalAddressName'       =>$request->physicalAddressName,
                'physicalAddressBox'        =>$request->physicalAddressBox,
                'physicalAddressLocation'   =>$request->physicalAddressLocation,
                'proxyName'                 =>$request->proxyName,
                'proxyEmail'                =>$request->proxyEmail,
                'proxyPhoneNumber'          =>$request->proxyPhoneNumber,
                'letter'                    =>$request->letter,
                'email'                     =>$request->email,
            ]);

            return Redirect::route('employer.show',['id'=>$employer->id]);

        }else
            return Redirect::back()->with('error','Invalid employer');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('auth.profile', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $data=request()->validate([
            'FirstName'=>'required',
            'LastName'=>'required',
            'email'=>' required',
        ]);
        
        $user = Auth::user();

        $emailExists=User::where('email',$request->email)
            ->where('id', '!=', $user->id)
            ->first();

        if($emailExists){
            Session::flash('notification',[
                'message' => 'The email you chose is already in use',
                'alert-type' => 'error',
            ]);
        }
        else{
            try { 
                User::where('FacultyID',$user->FacultyID)->update($request->except(['_token','_method']));

                Session::flash('notification',[
                    'message' => 'Profile updated successfully',
                    'alert-type' => 'success',
                ]);
            } catch (\Throwable $th) {
                Session::flash('notification',[
                    'message' => 'Error updating profile',
                    'alert-type' => 'error',
                ]);
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

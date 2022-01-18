<?php

namespace App\Http\Controllers;

use App\Http\Requests\GantiPasswordUpdateRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GantiPasswordController extends Controller
{
    public function create()
    {
        return view('gantipassword_form');
    }

    public function update(GantiPasswordUpdateRequest $request, $id)
    {
        User::where('id', Auth::user()->id)->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        flash('Data berhasil diupdate')->success();
        return back();
    }
}

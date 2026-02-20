<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('users.users');
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $users = DB::table('users')->where('id', $id)->get();
        return view('users.edit', ['users' => $users]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,employee,client',
        ]);

        DB::table('users')->where('id', $id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users')->with('success', 'Korisnik je uspješno ažuriran.');
    }


    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users')->with('success', 'Korisnik je uspješno obrisan.');
    }

    public function create()
    {
        return view('users.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,employee,client',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::table('users')->insert([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users')->with('success', 'Korisnik je uspješno dodan.');
    }
}

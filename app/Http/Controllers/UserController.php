<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('backend.user.index', compact('data'));
    }

    public function add()
    {
        return view('backend.user.add');
    }

    public function save(Request $req)
    {
        $check = User::where('username', $req->username)->first();
        if ($check != null) {
            Alert::info('Username sudah digunakan, silahkan gunakan username lain', 'Info Message');
        } else {
            $role = Role::where('name', 'superadmin')->first();
            $s = new User;
            $s->name = $req->name;
            $s->username = $req->username;
            $s->password = bcrypt($req->password);
            $s->save();
            $s->roles()->attach($role);
            Alert::success('Data Berhasil Di Simpan', 'Info Message');
        }
        return redirect('/user');
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('backend.user.edit', compact('data'));
    }

    public function update(Request $req, $id)
    {
        if ($req->password == null) {
            $s = User::find($id);
            $s->name = $req->name;
            $s->username = $req->username;
            $s->save();
            Alert::success('Data Berhasil Di Update', 'Info Message');
        } else {
            $s = User::find($id);
            $s->name = $req->name;
            $s->username = $req->username;
            $s->password = bcrypt($req->password);
            $s->save();
            Alert::success('Data Berhasil Di Update', 'Info Message');
        }
        return redirect('/user');
    }

    public function delete($id)
    {
        $delete = User::find($id)->delete();
        Alert::success('Data Berhasil Di Hapus', 'Info Message');
        return back();
    }
}

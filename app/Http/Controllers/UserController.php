<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Show user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('user.profile', ['user'=>Auth()->user()]);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail(Auth()->user()->id);
        $user->name = $request->name;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('user-profile');
    }

    public function list(Request $request)
    {
        $list = User::paginate(10);
        return view('user.list', ['list'=>$list]);
    }

    public function show(User $user)
    {
        \Log::debug($user);
        return view('user.show', ['user'=>$user]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:admin,manager,staff',
            'email' => ['email', function ($attribute, $value, $fail) {
                if (User::where('email', $value)->get()) {
                    $fail('The email aleady exists');
                }
            },]
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->type = $request->type;
        $user->save();

        return redirect('/user-show/' . $user->id);
    }

}

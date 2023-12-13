<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $title = 'Data User';
        return view('dashboard.user.index')->with(compact('title', 'users'));
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'username' => ['required', 'min:5', 'max:16', 'unique:users'],
                'password' => 'required|min:5|max:255',
                'isAdmin' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('user.index')->with('failed', $exception->getMessage());
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('user.index')->with('success', 'User baru berhasil ditambahkan!');
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
    public function update(Request $request, User $user)
    {
        try {
            $rules = [
                'name' => 'required|max:255',
                'username' => 'required|min:5|max:16|unique:users,username,' . $user->id,
                'isAdmin' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            User::where('id', $user->id)->update($validatedData);

            return redirect()->route('user.index')->with('success', "Data User $user->name berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('user.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            User::destroy($user->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('user.index')->with('failed', "User $user->name tidak dapat dihapus, karena sedang digunakan pada tabel lain!");
            }
        }

        return redirect()->route('user.index')->with('success', "User $user->name berhasil dihapus!");
    }

    public function resetPasswordAdmin(Request $request, User $user)
    {
        try {
            $rules = [
                'password' => 'required|min:5|max:255',
            ];

            $validatedData = $request->validate($rules);
            $validatedData['password'] = Hash::make($validatedData['password']);

            User::where('id', $user->id)->update($validatedData);

            return redirect()->route('user.index')->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return back()->with('failed', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

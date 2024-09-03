<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        return view('adminindex', compact('admins'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincreat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            // 'password' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->user_name,
            // 'password' => $request->password,
            'email' => $request->email,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.index');
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
        $admin = Admin::findOrFail($id);
        return view('adminedit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            // 'password' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image',
        ]);

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->user_name = $request->user_name;
        // $admin->password = $request->password;
        $admin->email = $request->email;
        $admin->image = $request->image;

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($admin->image);
            // Store the new image
            $admin->image = $request->file('image')->store('images', 'public');
        }

        $admin->save();

        return redirect()->route('admin.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        Storage::disk('public')->delete($admin->image);
        $admin->delete();
        return redirect()->route('admin.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Order;


class ClientvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        // $orders = Order::where('client_id', $clients)->get();

        return view('clientindex', compact('clients'));
        // , ['orders' => $orders]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientcreate');
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
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'image' => $imagePath,
        ]);

        return redirect()->route('client.index');
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
        $client = Client::findOrFail($id);
        return view('clientedit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image',
        ]);

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->user_name = $request->user_name;
        $client->email = $request->email;

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($client->image);
            // Store the new image
            $client->image = $request->file('image')->store('images', 'public');
        }

        $client->save();

        return redirect()->route('client.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        // Storage::disk('public')->delete($admin->image);
        $client->delete();

        return redirect()->route('client.index');
    }
    public function showOrders(string $id)
    {
        $client = Client::findOrFail($id);
        $orders = Order::where('client_id', $id)->with('product', 'address')->get();

        return view('client_orders', compact('client', 'orders'));
    }
}

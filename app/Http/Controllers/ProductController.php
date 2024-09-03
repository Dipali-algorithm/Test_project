<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::leftJoin('categories', 'products.cid', '=', 'categories.cid')
            ->select('products.*')
            ->get();
        return view('home', compact('products',));
    }

    public function create()
    {
        $products = Products::all();
        $categories = Category::all();
        return view('productsAdd', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'product_name' => 'required',
            'product_desc' => 'required',
            'product_price' => 'required|numeric',
            'product_weight' => 'required|numeric',
        ]);

        $product = new Products;
        $product->cid = $request->cid;
        $product->product_name = $request->product_name;
        $product->product_desc = $request->product_desc;
        $product->product_price = $request->product_price;
        $product->product_weight = $request->product_weight;
        $product->save();

        return redirect()->route('home')->with('success', 'Product created successfully.');
    }

    public function edit($pid)
    {
        $products = Products::findOrFail($pid);
        $categories = Category::all();

        return view('productsUpdate', compact('products', 'categories'));
    }

    public function update(Request $request, $pid)
    {
        $request->validate([
            'cid' => 'required|integer',
            'product_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string',
            'product_price' => 'required|numeric',
        ]);

        $products = Products::findOrFail($pid);
        $products->update($request->all());

        return redirect()->route('home')->with('success', 'Product updated successfully.');
    }

    public function destroy($pid)
    {
        $product = Products::find($pid);

        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found.');
        }

        $product->delete();

        return redirect()->route('home')->with('success', 'Product deleted successfully.');
    }

    public function addToCart($pid, Request $request)
    {
        $client = Auth::guard('client')->user();

        if (!$client) {
            return redirect()->route('client.login')->with('error', 'You must be logged in to add items to the cart.');
        }

        $product = Products::find($pid);

        if (!$product) {
            return redirect()->route('cart')->with('error', 'Product not found.');
        }

        $client = Auth::guard('client')->user();
        $ipAddress = $request->ip();

        $cartItem = CartDetail::updateOrCreate(
            ['product_id' => $product->pid, 'client_id' => $client->id],
            ['ip_address' => $ipAddress]
        );

        if (!$cartItem->wasRecentlyCreated) {
            $cartItem->increment('quantity');
        }

        return redirect()->route('cart')->with('success', 'Product added to cart.');
    }


    public function viewCart()
    {
        $client = Auth::guard('client')->user();
        $cartItems = CartDetail::where('client_id', $client->id)->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });
        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = CartDetail::find($id);

        if ($cartItem) {
            $quantity = $request->input('quantity');
            if ($quantity > 0) {
                $cartItem->update(['quantity' => $quantity]);
            } else {
                $cartItem->delete();
            }
        }

        return redirect()->route('cart')->with('success', 'Cart updated successfully.');
    }

    public function removeFromCart($id)
    {
        CartDetail::destroy($id);

        return redirect()->route('cart')->with('success', 'Item removed from cart.');
    }
}

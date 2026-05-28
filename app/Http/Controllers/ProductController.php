<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // SHOW PRODUCTS + SEARCH + FILTER
    public function index(Request $request)
    {
        $query = Product::query();

        if($request->search){
            $query->where('name','like','%'.$request->search.'%');
        }

        if($request->category){
            $query->where('category',$request->category);
        }

        if($request->min_price && $request->max_price){
            $query->whereBetween('price', [
                $request->min_price,
                $request->max_price
            ]);
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    // ADD TO CART
    // ADD TO CART
public function addToCart($id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    if(isset($cart[$id])){
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name"     => $product->name,
            "price"    => $product->price,
            "image"    => $product->image,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);

    return response()->json([
        'success'   => true,
        'cartCount' => count($cart),
        'message'   => $product->name . ' added to cart!'
        
    ]);
}
    // public function addToCart($id)
    // {
    //     $product = Product::findOrFail($id);

    //     $cart = session()->get('cart', []);

    //     if(isset($cart[$id])){
    //         $cart[$id]['quantity']++;
    //     } else {
    //         $cart[$id] = [
    //             "name" => $product->name,
    //             "price" => $product->price,
    //             "image" => $product->image,
    //             "quantity" => 1
    //         ];
    //     }

    //     session()->put('cart', $cart);
    //     return back();
    // }

    // REMOVE
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    // UPDATE QUANTITY
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back();
    }

    // CART PAGE
    public function cart()
    {
        return view('cart');
    }
    // Show form
public function create()
{
    return view('products.create');
}

public function increase($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'បានបន្ថែមចំនួនទំនិញ!');
}

public function decrease($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        if($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            // បើនៅសល់ត្រឹម ១ ហើយចុចដកទៀត គឺលុបទំនិញនោះចេញតែម្តង
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'បានបន្ថយចំនួនទំនិញ!');
}
public function shop() {
    $products = Product::all();
    // ប្តូរពី return view('shop') ទៅជា៖
    return view('products.shop', compact('products'));
}

public function categories() {
    // ប្តូរទៅជា៖
    return view('products.category');
}

// Save product
public function store(Request $request)
{
    // validation
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
        'image' => 'required|image'
    ]);

    // upload image
    $imageName = time().'.'.$request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    // save to database
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'category' => $request->category,
        'image' => 'images/'.$imageName
    ]);

    return redirect('/');
}
}

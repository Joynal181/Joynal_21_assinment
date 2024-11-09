<?php

namespace App\Http\Controllers;

use App\Models\Product;
use File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //product list, serach
    public function showProductList(Request $request)
    {
        $products = Product::when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where('product_id', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        })
        ->orderBy($request->input('sort', 'name'), $request->input('direction', 'asc'))
        ->paginate(5);

        return view('pages.index', compact('products'));
    }

    //show create product
    public function showCreateProduct(){
        return view('pages.create');
    }

    //create product
    public function createProduct(Request $request){
        $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageNameToStore = 'image' . md5(uniqid()) . time() . '.'. $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageNameToStore);
        }else{
            $imageNameToStore = null;
        }

        Product::create([
            'product_id' => $request->input('product_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image' => $imageNameToStore,
        ]);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    //show specific product
    public function show($id){
        $show = Product::find($id);
        // dd($show);
        if (!$show) {
            return redirect()->route('index')->with('error', 'Product not found');
        }
        return view('pages.show', compact('show'));
    }

    //show edit product
    public function showEditProduct($id){
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product not found.');
        }
        return view('pages.edit', compact('product'));
    }

    //edit product
    public function editProduct(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product not found.');
        }

        $request->validate([
            'product_id' => 'required|string|unique:products,product_id,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('images/' . $product->image))) {
                File::delete(public_path('images/' . $product->image));
            }

            $image = $request->file('image');
            $imageNameToStore = 'image' . md5(uniqid()) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageNameToStore);
        } else {
            $imageNameToStore = $product->image;
        }

        $product->update([
            'product_id' => $request->input('product_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image' => $imageNameToStore,
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');

    }

    //delete product
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            if ($product->image && File::exists(public_path('images/' . $product->image))) {
                File::delete(public_path('images/' . $product->image));
            }

            $product->delete();

            return redirect()->route('product.index')->with('success', 'Product deleted successfully along with its image.');
        } else {
            return redirect()->route('product.index')->with('error', 'Product not found.');
        }
    }
}

<?php


namespace App\Http\Controllers;


use App\Product;

use Illuminate\Http\Request;


class ProductController extends Controller

{ 

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    function __construct()

    {

         $this->middleware('permission:stack-list');

         $this->middleware('permission:stack-create', ['only' => ['create','store']]);

         $this->middleware('permission:stack-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:stack-delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $products = Product::latest()->paginate(5);

        return view('stack.index',compact('stacks'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('stacks.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        request()->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);


        Stack::create($request->all());


        return redirect()->route('stack.index')

                        ->with('success','Stack created successfully.');

    }


    /**

     * Display the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function show(Stack $stack)

    {

        return view('stacks.show',compact('stack'));

    }


    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit(Stack $stack)

    {

        return view('stacks.edit',compact('stack'));

    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Stack $stack)

    {

         request()->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);


        $stack->update($request->all());


        return redirect()->route('stacks.index')

                        ->with('success','Stack updated successfully');

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy(Stack $stack)

    {

        $stack->delete();


        return redirect()->route('stacks.index')

                        ->with('success','Stack deleted successfully');

    }

}
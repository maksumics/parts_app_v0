<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Item;
use App\Models\Picture;
use Image;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=null;
        if($request->subcategory_list > 0 && $request->car_list>0)
            $data = Item::where('subcategory_id', $request->subcategory_list)->where('car_id', $request->car_list)->paginate(10);
        $cats = Category::get();
        $brands = Brand::get();
        return view('index', compact('data', 'cats', 'brands'))->
            with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function admin(Request $request)
    {
        return view('items_admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::get();
        $brnds = Brand::get();

       
        return view('items_create', compact('cats', 'brnds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'categories_list' => 'required|numeric',
            'cars_list' => 'required|numeric',
            'amount' => 'required|numeric',
            'details' => 'required'
        ]);
        $item = new Item();
        $item->title = $request->title;
        $item->amount = $request->amount;
        $item->price = $request->price;
        $item->code = strtoupper(Str::random(5));
        $item->active = true;
        $item->details = $request->details;
        $sub = Subcategory::find($request->categories_list);
        $item->subcategory()->associate($sub);
        $car = Car::find($request->cars_list);
        $item->car()->associate($car);
        $item->save();

        if($request->file('images')!=null)
        {
            foreach($request->file('images') as $image)
            {
                $picture = new Picture();
                $rndTitle = Str::random(5) . '_.' . $image->getClientOriginalExtension();
                $resizedImage = Image::make($image->getRealPath());
                $resizedImage->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/') . $rndTitle);
                //$image->storeAs('public/images', $rndTitle);
                $picture->title=$rndTitle;
                $picture->path=$rndTitle;
                $picture->item()->associate($item);
                $picture->save();
            }
        }
        $newCode = $item->code;
        return redirect('/items/create')->with(['newCode' => $newCode]);
    }

    private function generateRandom()
    {
        $rnd = new String();
        $rnd =  Str::random(5);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Item::findOrFail($id);
        $images = Picture::where('item_id', $id)->get();
        return response()->json(['data' => $data, 'images' => $images]);
    }
    public function showByCode($code)
    {
        $data = Item::where('code', $code)->firstOrFail();
        $images = Picture::where('item_id', $data->id)->get();
        return response()->json(['data' => $data, 'images' => $images]);
    }

    public function sellItem($id)
    {
        $item = Item::findOrFail($id);
        if($item->amount > 0)
        {
            $item->amount--;
            $item->save();
            return response()->json(['status' => 'ok']);
        }
        else
        {
            return response()->json(['status' => 'error']);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $cats = Category::get();
        $brnds = Brand::get();
        return view('items_edit', compact('item', 'cats', 'brnds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $itemForUpdate = Item::findOrFail($id);
        if($itemForUpdate)
        {
            $request->validate([
                'title' => 'required',
                'price' => 'required|numeric',
                'subcategory_list' => 'required|numeric',
                'cars_list' => 'required|numeric',
                'amount' => 'required|numeric',
                'details' => 'required'
            ]);
            $itemForUpdate->title = $request->title;
            $itemForUpdate->amount = $request->amount;
            $itemForUpdate->price = $request->price;
            $sub = Subcategory::find($request->subcategory_list);
            $itemForUpdate->subcategory()->associate($sub);
            $car = Car::find($request->cars_list);
            $itemForUpdate->car()->associate($car);
            $itemForUpdate->save();
            if($request->file('images')!=null)
            {
                foreach($request->file('images') as $image)
                {
                    $picture = new Picture();
                    $rndTitle = Str::random(5) . '_.' . $image->getClientOriginalExtension();
                    $resizedImage = Image::make($image->getRealPath());
                    $resizedImage->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/') . $rndTitle);
                    $picture->title=$rndTitle;
                    $picture->path=$rndTitle;
                    $picture->item()->associate($itemForUpdate);
                    $picture->save();
                }
            }
            return redirect('/items/?subcategory_list=' . $request->subcategory_list . '&car_list=' . $request->cars_list);
        }
        else
        {

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

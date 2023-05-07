<?php

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::post('/add', function (Request $request) {

    $property = new Property();
    $property->city = $request->input('city');
    $property->district = $request->input('district');
    $property->width = $request->input('width');
    $property->length = $request->input('length');
    $property->category = $request->input('category');
    $property->kind = $request->input('kind');
    // $property->images = $request->input('images');
    $property->livingrooms = $request->input('livingrooms');
    $property->bedrooms = $request->input('bedrooms');
    $property->area = $request->input('area');
    $property->bathrooms = $request->input('bathrooms');
    $property->age = $request->input('age');
    $property->kitchen = $request->input('kitchen');
    $property->ac = $request->input('ac');
    $property->furnished = $request->input('furnished');
    $property->rentperiod = $request->input('rentperiod');
    $property->price = $request->input('price');
    $property->other = $request->input('other');

    $property->images = '';

    if ($files = $request->file('images')) {

        foreach ($files as $file) {

            $imageName = $file->getClientOriginalName() . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $property->images = $property->images . $imageName . ',';

            // $extension = $file->getClientOriginalName();
            // $fileName = time().'-' .$request->name.'.'.$extension; // I don't know where did you get this $request->name, I didn't find it on your code.

            // $created = Popup::create([
            //     'datep' => $request->datep[$key],
            //     'title' => $request->title[$key],
            //     'image_path' => $fileName
            // ]);

            // if($created){

            // $file->move('popups',$fileName); to store in public folder

            //  If you want to keep files in storage folder, you can use following : -

            // Storage::disk('public')->put('popups/'.$location,File::get($file));

            // Dont't forget to run 'php artisan storage:link'
            // It will store into your storage folder and you can access it by Storage::url('file_path)
            // }else{
            // Your error message.
            // }
        }
    }

    $property->save();

    if ($property) {
        return Response::json(
            $property,
            201
        );
    } else {
        return Response::json(
            ['error' => 'can not add the property'],
            201
        );
    }
});

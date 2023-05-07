<?php

use App\Models\Message;
use App\Models\Person;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/signup', function (Request $request) {
    $name = $request->input('name');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $password = $request->input('password');

    $user = User::where('email', '=', $email)->first();
    if ($user) {
        return Response::json(
            ['error' => 'User already exist'],
            201
        );
    } else {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = $password;

        $user->save();
        return Response::json(
            $user,
            200
        );
    }
});

Route::post('/login', function (Request $request) {

    $email = $request->input('email');
    $password = $request->input('password');

    $user = User::where('email', '=', $email)->where('password', '=', $password)->first();
    if ($user) {
        return Response::json(
            $user,
            201
        );
    } else {
        return Response::json(
            ['error' => 'User not exist'],
            201
        );
    }
});


Route::post('/add', function (Request $request) {

    $property = new Property();
    $property->city = $request->input('city');
    $property->district = $request->input('district');
    $property->width = $request->input('width');
    $property->length = $request->input('length');
    $property->category = $request->input('category');
    $property->kind = $request->input('kind');
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



Route::post('/edit', function (Request $request) {
    $id = $request->input('id');

    $property = Property::where('id', '=', $id)->first();

    $property->city = $request->input('city');
    $property->district = $request->input('district');
    $property->width = $request->input('width');
    $property->length = $request->input('length');
    $property->category = $request->input('category');
    $property->kind = $request->input('kind');
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
        }
    }

    $property->update();

    if ($property) {
        return Response::json(
            $property,
            201
        );
    } else {
        return Response::json(
            ['error' => 'can not edit the property'],
            201
        );
    }
});


Route::post('/delete', function (Request $request) {
    $id = $request->input('id');

    $property = Property::where('id', '=', $id)->delete();
    if ($property) {
        return Response::json(
            ['success' => 'property deleted'],
            201
        );
    } else {
        return Response::json(
            ['error' => 'can not delete the property'],
            201
        );
    }
});



Route::post('/home', function (Request $request) {
    $property = Property::all()->orderBy('id', 'desc');

    foreach ($property as $p) {
        $images = $p->images;
        $imagesList = explode(',', $images);
        unset($imagesList[sizeof($imagesList) - 1]);

        unset($property->images);

        $p->images = $imagesList;
    }
    return Response::json(
        $property,
        200
    );
});


Route::post('/details', function (Request $request) {

    $id = $request->input('id');

    $property = Property::where('id', '=', $id)->first();


    $images = $property->images;
    $imagesList = explode(',', $images);
    unset($imagesList[sizeof($imagesList) - 1]);

    unset($property->images);

    $property->images = $imagesList;

    return Response::json(
        $property,
        200
    );
});


Route::post('/search', function (Request $request) {

    $location = $request->input('location');
    if ($location == null) $location = "";
    $property = null;

    if ($request->input('minprice') && $request->input('minprice')) {
        $property = Property::where('city', 'LIKE', "%" . $location . "%")->orwhere('district', 'LIKE', "%" . $location . "%")->where('price', '>=', $request->input('minprice'))->where('price', '<=', $request->input('maxprice'))->orderBy('id', 'desc')->get();
    } else if ($request->input('minprice')) {
        $property = Property::where('city', 'LIKE', "%" . $location . "%")->orwhere('district', 'LIKE', "%" . $location . "%")->where('price', '>=', $request->input('minprice'))->orderBy('id', 'desc')->get();
    } else if ($request->input('maxprice')) {
        $property = Property::where('city', 'LIKE', "%" . $location . "%")->orwhere('district', 'LIKE', "%" . $location . "%")->where('price', '<=', $request->input('maxprice'))->orderBy('id', 'desc')->get();
    } else {
        $property = Property::where('city', 'LIKE', "%" . $location . "%")->orwhere('district', 'LIKE', "%" . $location . "%")->orderBy('id', 'desc')->get();
    }


    $images = $property->images;
    $imagesList = explode(',', $images);
    unset($imagesList[sizeof($imagesList) - 1]);

    unset($property->images);

    $property->images = $imagesList;

    return Response::json(
        $property,
        200
    );
});









Route::post('/send', function (Request $request) {
    $id = $request->input('id');

    $message = $request->input('message');

    $mess = new Message();
    $mess->userId = $id;
    $mess->message = $message;
    $mess->type = 0;

    if ($mess->save()) {
        return Response::json(
            ['success' => 'message sent'],
            200
        );
    } else {
        return Response::json(
            ['error' => 'message not sent'],
            201
        );
    }
});

Route::post('/chats', function (Request $request) {
    $chats = Message::all()->groupBy('userid')->orderBy('id', 'desc');
    $result = [];
    $i = 0;
    foreach ($chats as $chat) {
        $user = User::where('id', '=', $chat[0]->userid)->first();
        $result[$i] = $chat[0];
        $result[$i]['name'] = $user->name;
        $i = $i + 1;
    }

    if ($result) {
        return Response::json(
            $result,
            200
        );
    } else {
        return Response::json(
            ['error' => 'can not get chats'],
            201
        );
    }
});

Route::post('/adminsend', function (Request $request) {
    $id = $request->input('id');
    $message = $request->input('message');
    $mess = new Message();
    $mess->userId = $id;
    $mess->message = $message;
    $mess->type = 1;

    if ($mess->save()) {
        return Response::json(
            ['success' => 'message sent'],
            200
        );
    } else {
        return Response::json(
            ['error' => 'message not sent'],
            201
        );
    }
});



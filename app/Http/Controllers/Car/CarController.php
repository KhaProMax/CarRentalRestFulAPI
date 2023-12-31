<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Comment;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $location = $request->location;

        if (!$location) {
            $cars = Car::all();
        } else
            $cars = Car::where('LOCATION', $location)->get();

        if ($cars->isEmpty()) {
            return response()->json(['message' => 'No cars found'], 404);
        }

        foreach ($cars as $car) {
            $car->IS_AVAILABLE = true;

            $contract = Contract::where('LICENSE_PLATE', $car->LICENSE_PLATE)->where('RETURN_STATUS', "N")->get();
            if (!$contract->isEmpty()) {
                $car->IS_AVAILABLE = false;
            }

            $numberRent = Contract::where('LICENSE_PLATE', $car->LICENSE_PLATE)->where('RETURN_STATUS', "Y")->count();
            $star = Comment::where('LICENSE_PLATE', $car->LICENSE_PLATE)->avg('REVIEW');

            $car->STAR = ($numberRent > 0) ? round($star, 1) : 0;
            $car->TRIP = $numberRent;
            $car->user;
        }

        return response()->json(['message' => 'Cars retreived successfully!', 'data' => $cars], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = User::findOrFail($request->OWNER_ID);

        // if(!$user) {
        //     return response()->json(['error'=> 'User does not exist!', 'statusCode' => 404], 404);
        // }

        // Validate exist
        $rules = [
            'LICENSE_PLATE' => 'required|string',
            'OWNER_ID' => 'required|string',
            'NAME' => 'required|string',
            'LOCATION' => 'required|string',
            'LAST_CHECK' => 'date|date_format:Y-m-d',
            'BRAND' => 'required|string',
            'SEAT' => 'numeric|min:1',
            'TRANSMISSION' => 'required|string',
            'FUEL' => 'required|string',
            'CONSUMPTION' => 'required|numeric|min:1',
            'PRICE' => 'required|numeric|min:1',
            'SERVICE_FEE' => 'required|numeric|min:1',
            'INSURANCE_FEE' => 'required|numeric|min:1',
            'DESCRIPTION' => 'string',
            'MAP' => 'string|in:Y,N',
            'BLUETOOTH' => 'string|in:Y,N',
            'CAMERA_360' => 'string|in:Y,N',
            'CAMERA_SIDES' => 'string|in:Y,N',
            'CAMERA_JOURNEY' => 'string|in:Y,N',
            'CAMERA_BACK' => 'string|in:Y,N',
            'TIRE_SENSOR' => 'string|in:Y,N',
            'IMPACT_SENSOR' => 'string|in:Y,N',
            'SPEED_WARNING' => 'string|in:Y,N',
            'SKY_WINDOW' => 'string|in:Y,N',
            'GPS' => 'string|in:Y,N',
            'CHILD_SEAT' => 'string|in:Y,N',
            'USB' => 'string|in:Y,N',
            'SPARE_TIRE' => 'string|in:Y,N',
            'DVD' => 'string|in:Y,N',
            'ETC' => 'string|in:Y,N',
            'AIRBAG' => 'string|in:Y,N',
            'PICKUP_COVER' => 'string|in:Y,N',
            'FRONT_IMG' => 'string',
            'BACK_IMG' => 'string',
            'LEFT_IMG' => 'string',
            'RIGHT_IMG' => 'string',
        ];

        $request->validate($rules);
        // 
        $data = $request->all();

        $car = Car::create($data);

        return response()->json(['message' => 'Car created successfully!', 'data' => $car], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $car = Car::findOrFail($id);

        $numberRent = Contract::where('LICENSE_PLATE', $car->LICENSE_PLATE)->where('RETURN_STATUS', "Y")->count();
        $star = Comment::where('LICENSE_PLATE', $car->LICENSE_PLATE)->avg('REVIEW');

        $car->STAR = round($star, 1);
        $car->TRIP = $numberRent;

        $car->user;

        return response()->json(['message' => 'Query successfully!', 'data' => $car], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $car = Car::findOrFail($id);

        $rules = [
            'NAME' => 'string',
            'LOCATION' => 'string',
            'LAST_CHECK' => 'date|date_format:Y-m-d',
            'BRAND' => 'string',
            'SEAT' => 'numeric|min:1',
            'TRANSMISSION' => 'string',
            'FUEL' => 'string',
            'CONSUMPTION' => 'numeric|min:1',
            'PRICE' => 'numeric|min:1',
            'SERVICE_FEE' => 'numeric|min:1',
            'INSURANCE_FEE' => 'numeric|min:1',
            'DESCRIPTION' => 'string',
            'MAP' => 'string|in:Y,N',
            'BLUETOOTH' => 'string|in:Y,N',
            'CAMERA_360' => 'string|in:Y,N',
            'CAMERA_SIDES' => 'string|in:Y,N',
            'CAMERA_JOURNEY' => 'string|in:Y,N',
            'CAMERA_BACK' => 'string|in:Y,N',
            'TIRE_SENSOR' => 'string|in:Y,N',
            'IMPACT_SENSOR' => 'string|in:Y,N',
            'SPEED_WARNING' => 'string|in:Y,N',
            'SKY_WINDOW' => 'string|in:Y,N',
            'GPS' => 'string|in:Y,N',
            'CHILD_SEAT' => 'string|in:Y,N',
            'USB' => 'string|in:Y,N',
            'SPARE_TIRE' => 'string|in:Y,N',
            'DVD' => 'string|in:Y,N',
            'ETC' => 'string|in:Y,N',
            'AIRBAG' => 'string|in:Y,N',
            'PICKUP_COVER' => 'string|in:Y,N',
            'FRONT_IMG' => 'string',
            'BACK_IMG' => 'string',
            'LEFT_IMG' => 'string',
            'RIGHT_IMG' => 'string',
        ];

        // Validate the request data
        $request->validate($rules);

        if ($request->has('LICENSE_PLATE')) {
            return response()->json(['error' => 'Cannot modify LICENSE_PLATE, you may want to add a new car with that LICENSE_PLATE.', 'statusCode' => 500], 500);
        }

        if ($request->has('OWNER_ID')) {
            return response()->json(['error' => 'Cannot modify OWNER_ID, you may want to add a new car with that OWNER.', 'statusCode' => 500], 500);
        }

        if ($request->has('OWNER_ID')) {
            $car->OWNER_ID =  $request->OWNER_ID;
        }

        if ($request->has('NAME')) {
            $car->NAME =  $request->NAME;
        }

        if ($request->has('LOCATION')) {
            $car->LOCATION =  $request->LOCATION;
        }

        if ($request->has('LAST_CHECK')) {
            $car->LAST_CHECK =  $request->LAST_CHECK;
        }

        if ($request->has('BRAND')) {
            $car->BRAND =  $request->BRAND;
        }

        if ($request->has('SEAT')) {
            $car->SEAT = $request->SEAT;
        }
        if ($request->has('FUEL')) {
            $car->FUEL = $request->FUEL;
        }
        if ($request->has('CONSUMPTION')) {
            $car->CONSUMPTION = $request->CONSUMPTION;
        }
        if ($request->has('SERVICE_FEE')) {
            $car->SERVICE_FEE = $request->SERVICE_FEE;
        }
        if ($request->has('INSURANCE_FEE')) {
            $car->INSURANCE_FEE = $request->INSURANCE_FEE;
        }

        if ($request->has('BLUETOOTH')) {
            $car->BLUETOOTH = $request->BLUETOOTH;
        }
        if ($request->has('MAP')) {
            $car->MAP = $request->MAP;
        }
        if ($request->has('CAMERA_360')) {
            $car->CAMERA_360 = $request->CAMERA_360;
        }
        if ($request->has('CAMERA_SIDES')) {
            $car->CAMERA_SIDES = $request->CAMERA_SIDES;
        }
        if ($request->has('CAMERA_JOURNEY')) {
            $car->CAMERA_JOURNEY = $request->CAMERA_JOURNEY;
        }
        if ($request->has('CAMERA_BACK')) {
            $car->CAMERA_BACK = $request->CAMERA_BACK;
        }
        if ($request->has('TIRE_SENSOR')) {
            $car->TIRE_SENSOR = $request->TIRE_SENSOR;
        }
        if ($request->has('IMPACT_SENSOR')) {
            $car->IMPACT_SENSOR = $request->IMPACT_SENSOR;
        }
        if ($request->has('SPEED_WARNING')) {
            $car->SPEED_WARNING = $request->SPEED_WARNING;
        }
        if ($request->has('SKY_WINDOW')) {
            $car->SKY_WINDOW = $request->SKY_WINDOW;
        }
        if ($request->has('GPS')) {
            $car->GPS = $request->GPS;
        }
        if ($request->has('CHILD_SEAT')) {
            $car->CHILD_SEAT = $request->CHILD_SEAT;
        }
        if ($request->has('USB')) {
            $car->USB = $request->USB;
        }
        if ($request->has('SPARE_TIRE')) {
            $car->SPARE_TIRE = $request->SPARE_TIRE;
        }
        if ($request->has('DVD')) {
            $car->DVD = $request->DVD;
        }
        if ($request->has('ETC')) {
            $car->ETC = $request->ETC;
        }
        if ($request->has('AIRBAG')) {
            $car->AIRBAG = $request->AIRBAG;
        }
        if ($request->has('PICKUP_COVER')) {
            $car->PICKUP_COVER = $request->PICKUP_COVER;
        }
        if ($request->has('FRONT_IMG')) {
            $car->FRONT_IMG = $request->FRONT_IMG;
        }
        if ($request->has('BACK_IMG')) {
            $car->BACK_IMG = $request->BACK_IMG;
        }
        if ($request->has('LEFT_IMG')) {
            $car->LEFT_IMG = $request->LEFT_IMG;
        }
        if ($request->has('RIGHT_IMG')) {
            $car->RIGHT_IMG = $request->RIGHT_IMG;
        }

        if ($request->has('TRANSMISSION')) {
            $car->TRANSMISSION = ($request->TRANSMISSION);
        }

        if (!$car->isDirty()) {
            return response()->json(['error' => 'Your input values are the same in database system, nothing changed', 'data' => $car], 409);
        }

        $car->save();

        return response()->json(['message' => 'Car updated successfully!', 'data' => $car], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $car = Car::findOrFail($id);

        $car->delete();

        return response()->json(['message' => 'Car deleted successfully!', 'data' => $car], 200);
    }

    /**
     * Show xe cua 1 user bat ky.
     */
    public function getCarsOfOwner(string $owner_id)
    {
        $cars = Car::where('OWNER_ID', $owner_id)->get();

        return response()->json(['message' => 'Cars retreived successfully!', 'data' => $cars], 200);
    }

    /**
     * Filter cars based on request.
     */
    public function filter(Request $request)
    {
        $filters = $request->json()->all();

        $cars = Car::query();

        foreach ($filters as $key => $value) {
            $cars->where($key, $value);
        }

        $filteredCars = $cars->skip(2)->take(2)->get();

        return response()->json(['message' => 'Cars retreived successfully!', 'data' => $filteredCars], 200);
    }

    public function searchcar(Request $request)
    {
        $filters = $request->json()->all();

        dd($filters);

        return response()->json(['message' => 'Cars retreived successfully!', 'data' => $filters], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCars($userId) {

        $user = User::find($userId);

        $userPosition = $user->position;
        if ($user->position_id == null) {
            return response()->json(['error' => 'user position not set'], 200);
        }
        $availableCarCategories = $userPosition->car_categories;

        $availableCars = new Collection;

        foreach ($availableCarCategories as $carCategory) {
            $availableCars = $availableCars->merge($carCategory->cars);
        }

        return $availableCars;
    }

    public function index()
    {

        $availableCars = $this->getCars(Auth()->user()->id);
        return view('home', compact('availableCars'));
    }

    public function list(Request $request) {
        $user = $request->user();
        
        $data = $request->validate([
            'start_datetime' => 'date',
            'end_datetime' => 'date'
        ]);
        
        $availableCars = $this->getCars($user->id, $data);
        return view('home', compact('availableCars'));
    }

    public function getCarsSql($userId, $data)
    {
        $start_datetime = Carbon::parse($data['start_datetime'])->format('Y-m-d H:i:s');
        $end_datetime = Carbon::parse($data['end_datetime'])->format('Y-m-d H:i:s');

        if (($data['filter_field']) && ($data['filter_value'])) {
            $filter = match($data['filter_field']) {
                'category' => 'car_category.name',
                'model' => 'car.model',
            };
            $where = " and ".$filter. " = '" . $data['filter_value']."'";
        }
    
        $query = "
            select car.id, car.model, driver.first_name, driver.last_name, car.category_id, car.driver_id, car_category.name, car_category.description from cars as car 
            left join drivers driver
            on driver.id = car.driver_id
            left join car_categories as car_category
            on car_category.id = car.category_id
            where car.category_id in (
                select car_category_id from car_category_positions where position_id = ".User::find($userId)->position_id."
            ) and car.id not in ( 
                select id from car_orders WHERE (
                    start_datetime <= STR_TO_DATE('".$end_datetime."', '%Y-%m-%d %H:%i:%s') and 
                    end_datetime >= STR_TO_DATE('".$start_datetime."', '%Y-%m-%d %H:%i:%s')
                    ) 
            )
        ".$where;

        $availableCars = DB::select($query);

        return $availableCars;
    }

    public function order(Request $request) {
        $user = $request->user();

        $data = $request->validate([
            'start_datetime' => 'date',
            'end_datetime' => 'date',
            'filter_field' => 'string',
            'filter_value' => 'string',
        ]);

        $availableCars = $this->getCarsSql($user->id, $data);
        return view('order', compact('availableCars'));
    }

    
}

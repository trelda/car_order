<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function list(Request $request, $id) {

        $user = $request->user();
        if (!$user) {
            return response('Unauthorized', 401);
        }

        $availableCars = (new HomeController())->getCars($user->id);

        return response()->json(['availableCars' => $availableCars], 200);
    }

    public function order(Request $request)
    {
        $data = $request->validate([
            'start_datetime' => 'date',
            'end_datetime' => 'date',
            'filter_field' => 'string',
            'filter_value' => 'string',
        ]);
        $user = $request->user();
        if (!$data) {
            return response('date range not set', 200);
        }
        $availableCars = (new HomeController())->getCarsSql($user->id, $data);
        return response()->json(['request' => $availableCars], 200);
    }

}

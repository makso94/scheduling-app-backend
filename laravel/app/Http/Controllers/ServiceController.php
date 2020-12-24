<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{

    public function getAll()
    {
        return new ServiceResource(Service::all());
    }


    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:45'],
                'description' => ['max:45'],
                'price' => ['required', 'integer'],
                'duration' => ['required', 'integer']
            ]);
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->duration = $request->duration;
            $service->save();
            return response()->json(['msg' => 'You have successfully created a service.'], 201);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }


    public function get($id)
    {
        return new ServiceResource(Service::findOrFail($id));
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:45'],
                'description' => ['max:45'],
                'price' => ['required', 'numeric'],
                'duration' => ['required', 'integer']
            ]);
            $service = Service::findOrFail($id);
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->duration = $request->duration;
            $service->save();
            return response()->json(['msg' => 'You have successfully updated a service.'], 201);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }


    public function delete($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return response()->json(['msg' => 'The service is successfully deleted.'], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The service is already deleted.'], 405);
        }
    }
}

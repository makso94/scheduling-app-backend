<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return new ServiceResource(Service::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:45'],
                'description' => ['required', 'max:45'],
                'price' => ['required', 'integer'],
                'duration' => ['required', 'integer']
            ]);
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->duration = $request->duration;
            $service->save();
        } catch (Exception $e) {
            return response('The given data was invalid', 422);
        }


        return response('You have successfully created a service.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        return new ServiceResource(Service::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
        } catch (Exception $e) {
            return response('The service is already deleted.', 405);
        }

        return response('The service is successfully deleted.', 200);
    }
}

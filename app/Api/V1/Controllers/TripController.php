<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Trip;
use Dingo\Api\Routing\Helpers;

class TripController extends Controller
{
    use Helpers;


    public function index()
	{
    	$currentUser = JWTAuth::parseToken()->authenticate();
    	return $currentUser
    	    ->trip()
    	    ->orderBy('created_at', 'DESC')
    	    ->get()
    	    ->toArray();
	}


	public function store(Request $request)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $trip = new Trip;
	
	    $trip->user_id = $request->get('user_id');
	    $trip->name = $request->get('name');
	    $trip->start_date = $request->get('start_date');
	    $trip->total_km = $request->get('total_km');
	    $trip->cover_photo_path = $request->get('cover_photo_path');
	    $trip->likes = $request->get('likes');
	
	    if($currentUser->trip()->save($trip))
	        return $this->response->created();
	    else
	        return $this->response->error('could_not_create_trip', 500);
	}


	public function show($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $trip = $currentUser->trip()->find($id);
	
	    if(!$trip)
	        throw new NotFoundHttpException; 
	
	    return $trip;
	}


	public function update(Request $request, $id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $trip = $currentUser->trip()->find($id);
	    if(!$trip)
	        throw new NotFoundHttpException;
	
	    $trip->fill($request->all());
	
	    if($trip->save())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_update_trip', 500);
	}


	public function destroy($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $trip = $currentUser->trip()->find($id);
	
	    if(!$trip)
	        throw new NotFoundHttpException;
	
	    if($trip->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_trip', 500);
	}
}

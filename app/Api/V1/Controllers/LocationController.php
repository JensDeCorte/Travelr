<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Location;
use Dingo\Api\Routing\Helpers;

class LocationController extends Controller
{
    use Helpers;


    public function index()
	{
    	$currentUser = JWTAuth::parseToken()->authenticate();
    	return $currentUser
    	    ->location()
    	    ->orderBy('created_at', 'DESC')
    	    ->get()
    	    ->toArray();
	}


	public function store(Request $request)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $location = new Location;
	
	    $location->country_code = $request->get('country_code');
	    $location->name = $request->get('name');
	    $location->city = $request->get('city');
	    $location->province = $request->get('province');
	    $location->country = $request->get('country');
	    $location->time_zone = $request->get('time_zone');
	    $location->lat = $request->get('lat');
	    $location->long = $request->get('long');
	
	    if($currentUser->location()->save($location))
	        return $this->response->created();
	    else
	        return $this->response->error('could_not_create_location', 500);
	}


	public function show($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $location = $currentUser->location()->find($id);
	
	    if(!$location)
	        throw new NotFoundHttpException; 
	
	    return $location;
	}


	public function update(Request $request, $id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $location = $currentUser->location()->find($id);
	    if(!$location)
	        throw new NotFoundHttpException;
	
	    $location->fill($request->all());
	
	    if($location->save())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_update_location', 500);
	}


	public function destroy($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $location = $currentUser->location()->find($id);
	
	    if(!$location)
	        throw new NotFoundHttpException;
	
	    if($location->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_location', 500);
	}
}

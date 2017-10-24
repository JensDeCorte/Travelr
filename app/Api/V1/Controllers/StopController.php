<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Stop;
use Dingo\Api\Routing\Helpers;

class StopController extends Controller
{

    use Helpers;


    public function index()
	{
    	$currentUser = JWTAuth::parseToken()->authenticate();
    	return $currentUser
    	    ->stops()
    	    ->orderBy('created_at', 'DESC')
    	    ->get()
    	    ->toArray();
	}


	public function store(Request $request)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $stop = new Stop;
	
	    $stop->name = $request->get('name');
	    $stop->description = $request->get('description');
	    $stop->trip_id = $request->get('trip_id');
	    $stop->views = $request->get('views');
	    $stop->deleted = $request->get('deleted');
	    $stop->likes = $request->get('likes');
	    $stop->arrival_time = $request->get('arrival_time');
	
	    if($currentUser->stops()->save($stop))
	        return $this->response->created();
	    else
	        return $this->response->error('could_not_create_stop', 500);
	}


	public function show($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $stop = $currentUser->stops()->find($id);
	
	    if(!$stop)
	        throw new NotFoundHttpException; 
	
	    return $stop;
	}


	public function update(Request $request, $id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $stop = $currentUser->stops()->find($id);
	    if(!$stop)
	        throw new NotFoundHttpException;
	
	    $stop->fill($request->all());
	
	    if($stop->save())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_update_stop', 500);
	}


	public function destroy($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $stop = $currentUser->stops()->find($id);
	
	    if(!$stop)
	        throw new NotFoundHttpException;
	
	    if($stop->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_stop', 500);
	}

}

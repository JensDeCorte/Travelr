<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Follower;
use Dingo\Api\Routing\Helpers;

class FollowerController extends Controller
{
    use Helpers;


    public function index()
	{
    	$currentUser = JWTAuth::parseToken()->authenticate();
    	return $currentUser
    	    ->followers()
    	    ->orderBy('created_at', 'DESC')
    	    ->get()
    	    ->toArray();
	}


	public function store(Request $request)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $follower = new Follower;
	
	    $follower->follower_id = $request->get('follower_id');
	    $follower->followed_id = $request->get('followed_id');
	
	    if($currentUser->followers()->save($follower))
	        return $this->response->created();
	    else
	        return $this->response->error('could_not_create_follower', 500);
	}


	public function show($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $follower = $currentUser->followers()->find($id);
	
	    if(!$follower)
	        throw new NotFoundHttpException; 
	
	    return $follower;
	}


	public function update(Request $request, $id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $follower = $currentUser->followers()->find($id);
	    if(!$follower)
	        throw new NotFoundHttpException;
	
	    $follower->fill($request->all());
	
	    if($follower->save())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_update_follower', 500);
	}


	public function destroy($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $follower = $currentUser->followers()->find($id);
	
	    if(!$follower)
	        throw new NotFoundHttpException;
	
	    if($follower->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_follower', 500);
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Media;
use Dingo\Api\Routing\Helpers;

class MediaController extends Controller
{
    use Helpers;


    public function index()
	{
    	$currentUser = JWTAuth::parseToken()->authenticate();
    	return $currentUser
    	    ->media()
    	    ->orderBy('created_at', 'DESC')
    	    ->get()
    	    ->toArray();
	}


	public function store(Request $request)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $media = new Media;
	
	    $media->stop_id = $request->get('stop_id');
	    $media->caption = $request->get('caption');
	    $media->image = $request->get('image');
	    $media->image_thumb = $request->get('image_thumb');
	
	    if($currentUser->stops()->save($media))
	        return $this->response->created();
	    else
	        return $this->response->error('could_not_create_media', 500);
	}


	public function show($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $media = $currentUser->media()->find($id);
	
	    if(!$media)
	        throw new NotFoundHttpException; 
	
	    return $media;
	}


	public function update(Request $request, $id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $media = $currentUser->media()->find($id);
	    if(!$media)
	        throw new NotFoundHttpException;
	
	    $media->fill($request->all());
	
	    if($media->save())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_update_media', 500);
	}


	public function destroy($id)
	{
	    $currentUser = JWTAuth::parseToken()->authenticate();
	
	    $media = $currentUser->media()->find($id);
	
	    if(!$media)
	        throw new NotFoundHttpException;
	
	    if($media->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_media', 500);
	}
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\api\Base\BaseController;

class UserController extends BaseController
{
    public function update_user()
    {
    $whereIn =Array('Swallelief','Bart pinnen','Nenad..mortier','Anthonywiersema','Rocky','Gtasken1981',
    				'Spiegel54','Khandy120',);
    $UpdatedID =Array();
    $UsersArray=User::whereIn("name",$whereIn)->get();
    if($UsersArray){
       foreach($UsersArray as $key=>$User){
    		if($User){		
    			$userq = User::where('user_id',$User->user_id)->first();
    			$userupdates= User::where('user_id',$userq->user_id)->update(['user_type'=>'customer']);
    			if($userupdates){
    				$UpdatedID[]=$userq->user_id;
    			}
    		}
    	}	
    }

    return  $this->SuccessResponse($UpdatedID,__('Users info which updated'));
   }
}

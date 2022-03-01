<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Validator;
use App\Models\Note;
use App\Models\User;
use App\Http\Controllers\api\Base\BaseController;

class NoteController extends BaseController
{
  public function add(Request $request){
    $request= (object) $request->data;
    $data =Array();
    $data['user_id']=$request->user_id;
    $data['created_by']=$request->created_by;        
    $data['text']=$request->text;
    $data['name']=$request->name;   

    if($request->id){
       $save= Note::where('id',$request->id)->update($data);
        if($save){
            return $this->SuccessResponse($save,__('Note Updated Successfully!'));
        }else{
             return $this->ErrorResponse(__('Note not Updated Successfully!'));
        }
    }else{
       $save= Note::create($data);
       if($save){
            return $this->SuccessResponse($save,__('Note Created Successfully!'));
        }else{
             return $this->ErrorResponse(__('Note not Created Successfully!'));
        }
    }
  }

  public function list(Request $request){
    $request= (object) $request->data;
    if($request->user_id){
        $list=Note::where('user_id',$request->user_id)->get();
        if($list){
            return $this->SuccessResponse($list,__('Note List Successfully!'));
        }else{
             return $this->ErrorResponse(__('Note is not available!'));
        }
    }else{
        return $this->ErrorResponse(__('Please provide user_id !'));    
    }
  }
}

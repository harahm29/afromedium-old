<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Base\BaseController;
use Validator;
use App\Models\Im_msg;
use App\Models\User;
use Illuminate\Support\Collection;
use \Carbon\Carbon;
use App\Models\Unassignmsg;

class ChatController extends BaseController
{
    
    public function get_msg(Request $request){

        $request= (object) $request->data;
        
        if($request->user_id){

            $data =Array();

            $data['msg']=Im_msg::with(['to_users','from_users'])->where('assign_user',$request->user_id)->where('is_new','1')->orderBy('id','DESC')->first();
            
            $where =Array('user_id'=>$request->user_id,'notify'=>0); 
        
            $data['unassign'] = Unassignmsg::with('msg')->where($where)->first();
            if($data['unassign']){
                try {
            
                    $unassign->update([
                        'notify' => 1,
                    ]);

                } catch (\Throwable $th) {

                }
            }
            

            if($data['msg']){

                return $this->SuccessResponse($data,__('Message is Successfully Provided!'));
            }else{
                return $this->ErrorResponse(__('Message not founded for you!'));
            }
        }else{
            return $this->ErrorResponse(__('Please provide user_id !'));    
        }

    }


    public function get_msg_count(Request $request){

        $request= (object) $request->data;
        
        if($request->user_id){
            $msg=Im_msg::where('assign_user',$request->user_id)->where('assign_user',$request->user_id)->where('is_new','1')->orderBy('id','DESC')->count();
            
            if($msg){

                return $this->SuccessResponse($msg,__('Message is Successfully Provided!'));
            }else{
                return $this->ErrorResponse(__('Message is not Successfully Provided!'));
            }
        }else{
            return $this->ErrorResponse(__('Please provide user_id !'));    
        }

    }

    public function update(Request $request){

       
        if($request->id){
             $data =Array();
             if($request->unassignmsg=='unassignmsg'){
                $data['assign_user'] = NULL;
             }else{
                $data['assign_user'] = $request->user_id;
             }
             $data['reply'] = '0';
             $data['assign_time'] = Carbon::now()->format('Y-m-d H:i:s');
             
             $msg=Im_msg::where('id',$request->id)->update($data);
             $info =Array();
             if($request->unassignmsg=='unassignmsg'){
                $info['user_id']=$request->user_id;
                $info['msg_id']=$request->id;
                $info['notify']=0;
                $info['time']=Carbon::now()->format('Y-m-d H:i:s');
                if($info){
                  $update=  Unassignmsg::create($info);    
                }
                
             }

             if($msg){
                return $this->SuccessResponse($msg,__('Message is Successfully Updated!'));
            }else{
                return $this->ErrorResponse(__('Message is not Successfully Updated!'));
            }
        }else{
            return $this->ErrorResponse(__('Please provide user_id,message id !'));    
        }


    }

    public function newmessage($assign_user=null){
            ///dd($request->all());
            //$request= (object) $request->data;
            if($assign_user=='assign_user'){

                 $records = Im_msg::select('im_msg.*')    
                ->where('is_new','1')
                ->with(['from_users'])
                 ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
                })
                //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
                ->whereNotNull('assign_user')
                ->orderBy('id','DESC')
                ->get();

            }else{
                 $records = Im_msg::select('im_msg.*')    
                ->where('is_new','1')
                ->with(['from_users'])
                     ->whereHas('from_users', function($q){
                    $q->where('user_type', 'customer');
                 })
                 //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
                ->whereNull('assign_user')
                ->orderBy('id','DESC')
                ->get();
            }
           

          if($records){
                return $this->SuccessResponse($records,__('Message list!'));
            }else{
                return $this->ErrorResponse(__('Message list!'));
            }   

    }




    




}

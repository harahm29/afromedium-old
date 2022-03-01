<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\Base\BaseController;
use Validator;
use App\Models\Im_msg;
use App\Models\User;
use DataTables;
use Illuminate\Support\Collection;
use App\Models\Unassignmsg;
use \Carbon\Carbon;

class MsgController extends BaseController
{
    
    public function view($id=null)
    {

        if(!$id){
            return $this->ErrorResponse(__('id is required!'));  
        }

        $list = Im_msg::with(['to_users','from_users'])->find(base64_decode($id));
        
         if($list) {
             
             if($list->from_user&&$list->to_user&&$list->is_new==1){
               Im_msg::where(['from_user'=>$list->from_user,'to_user'=>$list->to_user])->update(['is_new'=>0]);
             }else if($list->from_user&&$list->is_new==1){
                Im_msg::where(['from_user'=>$list->from_user])->update(['is_new'=>0]);
             }else if($list->to_user&&$list->is_new==1){
                Im_msg::where(['to_user'=>$list->to_user])->update(['is_new'=>0]);
             }else{
                Im_msg::where(['id'=>$list->id])->update(['is_new'=>0]);
             }

             return $this->SuccessResponse($list,__('Message info'));
         }else{
             return $this->ErrorResponse(__('Something Went Wrong!'));
         }
    }


    public function get_list(Request $request){

        $request= (object) $request->data;
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $search_arr = $request->search;
        $searchValue='';
        if($search_arr){
        $searchValue = $search_arr['value']; // Search value
        }

        
        if(isset($request->unread)){
          
            $totalRecords = Im_msg::select('count(*) as allcount')->where('is_new',1)
            //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY to_user,from_user)")
            ->with(['from_users'])

            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->count();

            $totalRecordswithFilter = Im_msg::select('count(*) as allcount')
            ->where('is_new',1)
            //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY to_user,from_user)")
            ->where('name', 'like', '%' .$searchValue . '%')->with(['to_users'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })->count();

            $records = Im_msg::where('im_msg.name', 'like', '%' .$searchValue . '%')
            ->select('im_msg.*')
            ->orderBy('id','DESC')
            ->where('is_new',1)
            //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY to_user,from_user)")
            ->with(['to_users','from_users','profilem'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            
            ->skip($start)
            ->take($rowperpage)
            ->get();
            //->whereIn('to_user',[8,11])
        }else{

            $totalRecords = Im_msg::select('count(*) as allcount')->with(['from_users'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
            ->count();
            
            $totalRecordswithFilter = Im_msg::select('count(*) as allcount')
            ->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
            ->with(['from_users'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->where('name', 'like', '%' .$searchValue . '%')->count();

            $records = Im_msg::where('im_msg.name', 'like', '%' .$searchValue . '%')
            ->select('im_msg.*')
            ->orderBy('id','DESC')
            ->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
            ->with(['to_users','from_users','profilem'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->skip($start)
            ->take($rowperpage)
            ->get();
            //->whereIn('to_user',[8,11])

        }


    

        $data_arr = array();

        foreach($records as $record){
          
           $id = $record->id;
           $born = $record->born;
           $name = $record->name;
           $msg = $record->msg;
           $is_new  = $record->is_new;
           $to_user  = $record->to_users;
           $from_user= $record->from_users;
           $profilem= $record->profilem;

           $to  = $record->to_user;
           $from= $record->from_user;
           $assign_user=$record->assign_user;
           $data_arr[] = array(
             "id" => $id,
             "born" => $born,
             "name" => $name,
             "msg" => $msg,
             "is_new"=>$is_new,
             "to_user"=>$to,
             "from_user"=>$from,
             "to_users"=>$to_user,
             "from_users"=>$from_user,
             "profilem"=>$profilem,
             "assign_user"=>$assign_user,
             
           );
        }
        
        $collection =collect($data_arr);
        $sorted = $collection->sortBy([
            ['born', 'desc'],
            ['is_new','asc'],
        ]);



        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $sorted
        );

        return json_encode($response);
        exit;
    }


    public function count_list_of_msg(Request $request){

        $request= (object) $request->data;
        $unread ='';
        if(isset($request->unread)&&$request->unread!=''){
            
            $totalRecords = Im_msg::select('count(*) as allcount')->where('is_new',1)
            //->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY to_user,from_user)")
            ->with(['from_users'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->count();

            $unread =$request->unread;
           
        }else{

            $totalRecords = Im_msg::select('count(*) as allcount')->with(['from_users'])
            ->whereHas('from_users', function($q){
                $q->where('user_type', 'customer');
            })
            ->whereRaw("id IN(select MAX(id) FROM im_msg GROUP BY from_user)")
            ->count();
            
            
        }

        $response = array(
           "iTotalRecords" => $totalRecords,
           "unread"=>$unread
        );

        return json_encode($response);
        


    }

    //Send the Message
    public function SendMessage(Request $request)
    {
        $createArray = array();
        $request= (object) $request->data;
        if(!$request->msg&&!$request->from_user&&!$request->to_user&&!$request->name) {

            return $this->ErrorResponse(__('Id,from_user,to_user is required!'));  

         }  
        
        $fromDelete = 0;
        $toDelete = 0; 
        $firstIm = false; 
        $popularity = true;
        $system = 0; 
        $is_new = 1; 
        $send = 0; 
        $msgHash = '';

        if($request->system){
           $system = 1;   
        }

        $createArray['msg']=$request->msg;
        $createArray['name']=$request->name;
        $createArray['from_user']=$request->from_user;
        $createArray['to_user']=$request->to_user;
        $createArray['is_new']=$is_new;

        $createArray['born'] = date('Y-m-d H:i:s');
        $createArray['name'] = $request->name;
        $createArray['system'] = $system;
        $createArray['send'] = $send;
        $createArray['msg_hash'] = $msgHash;
        $createArray['from_user_deleted'] = $fromDelete;
        $createArray['to_user_deleted'] =$toDelete;
        $createArray['reply'] ='1';              
            

        $records = Im_msg::create($createArray);
         $unassignmsg =false;
        if($request->id){
           Im_msg::where('id',$request->id)->update(['is_new'=>0,'reply'=>'1']); 
           $createArray = Array('user_id'=>$request->user_id,
                                'msg_id'=>$request->id,
                                'reply'=>1,
                                'time'=>Carbon::now()->format('Y-m-d H:i:s')
                                );
          $unassignmsg= Unassignmsg::create($createArray);

        }

        if($records) {
            if($unassignmsg){
                 return $this->SuccessResponse($records,__('Message sent successfully!! Please provide check Other Messages'));
            }else{
                return $this->SuccessResponse($records,__('Message sent successfully!!'));
            }
           
        }else{
            return $this->ErrorResponse(__('Message not sent successfully!!'));
        }
    }
    
    //Send the New Notification
    public function get_user(Request $request)
    {
        $request= (object) $request->data;

        if(!$request->id) {

            return $this->ErrorResponse(__('Id is required!'));  

         }  
         //return $this->SuccessResponse(base64_decode($request->id),__('Call List:'));
         $list= User::with(['profile','uinfo'])->where('user_id',base64_decode($request->id))->first();

         if($list) {
             return $this->SuccessResponse($list,__('Call List:'));
         }else{
             return $this->ErrorResponse(__('Something Went Wrong!'));
         }
    }


    public function get_view_message(Request $request)
    {
        $request= (object) $request->data;
        //return  $this->SuccessResponse($request,__('Message List:'));
        $NewMsg =Array();
        //dd($request->from_user);
        if (!$request->from_user&&!$request->to_user&&!$request->limit) {

                return $this->ErrorResponse(__('from_user,to_user and limit are required!'));  

        }  
        $where =array(base64_decode($request->from_user),base64_decode($request->to_user)); 

        $datas = Im_msg::with(['to_users','from_users'])->orWhereIn('from_user',$where)->whereIn('to_user',$where)->orderBy('im_msg.id','Desc');
        $total_count =$datas->count();
        if($request->limit!='All'){
            $datas->limit($request->limit);
        }
        // $NewMsg=$datas->get()->toArray();
       
        // $newinfo=collect($NewMsg); 
        // $my =$newinfo->sortBy("id");  
        //dd($my);

        $data['data']= $datas->get();
        $data['total_count']= $total_count;

        if($data) {
             return $this->SuccessResponse($data,__('Message List:'));
        }else{
             return $this->ErrorResponse(__('Something Went Wrong!'));
        }

    }


    public function change_user(Request $request)
    {
        $request= (object) $request->data;
         if (!$request->id&&!$request->user_id) {
                return $this->ErrorResponse(__('Id,user_id Are required!'));  
        } 

         $message = Im_msg::where('id',$request->id)->update(['assign_user'=>$request->user_id]);
         if($message) {
             return $this->SuccessResponse($message,__('Message List:'));
         }else{
             return $this->ErrorResponse(__('Something Went Wrong!'));
         }

    }

    // public function get_online_user(Request $request){
    //     $request= (object) $request->data;
    //      if (!$request->id&&!$request->user_id) {
    //             return $this->ErrorResponse(__('Id,user_id Are required!'));  
    //     } 

    //      $message = Im_msg::where('id',$request->id)->update(['assign_user'=>$request->user_id]);
    //      if($message) {
    //          return $this->SuccessResponse($message,__('Message List:'));
    //      }else{
    //          return $this->ErrorResponse(__('Something Went Wrong!'));
    //      }
    // }

    
}

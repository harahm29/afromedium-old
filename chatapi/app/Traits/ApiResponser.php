<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
	protected function SuccessResponse($data,$message='Success',$code=200){

        $response['error'] = '';
        $response['data'] = $data;

        if(!empty($message))
        $response['message'] = $message;
        $response['success'] = true;
		return response()->json($response,$code);
	}

	protected function LoginResponse($data,$token,$message='Success',$code=200){

        $response['error'] = "";

        $data = $data;
        $data['token_data'] = [
                'token'=>$token,
                'type'=>'Bearer'
        ];
        $response['data'] = $data;
        if(!empty($message))
         $response['message'] = $message;

        $response['success'] = true;
		return response()->json($response,$code);
	}

	protected function ErrorResponse($message='Error',$code=400,$trace=[]){

        if(!empty($message))
        $response['error'] = $message;

        $response['data'] =(object)[];

        // $response['trace'] = $trace->getTrace()[0]['args'];
        $response['success'] = false;
        return response()->json($response, $code);
        }
        protected function ErrorResponseArray($message='Error',$code=400,$trace=[]){

                if(!empty($message))
                $response['error'] = $message;

                $response['data'] =[];

                // $response['trace'] = $trace->getTrace()[0]['args'];
                $response['success'] = false;
                return response()->json($response, $code);
                }

	protected function SuccessList($data,$message='Success',$code=200,$is_last=0){


        $response['error'] = array();
        $response['data'] = $data;
        $response['data']['is_last'] = $is_last;
        if(!empty($message))
         $response['data']['message'] = $message;
        $response['success'] = true;
		return response()->json($response,$code);
	}

	protected function showAll(Collection $collection,$code=200){
		return $this->SuccessResponse($collection,'',$code);
	}

	protected function showOne(Model $model,$code=200){
		return $this->SuccessResponse($model,'',$code);
	}
}
?>

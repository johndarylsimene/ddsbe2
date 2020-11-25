<?php
    namespace App\Traits;
    use Illuminate\Http\Response;
    

trait ApiResponser{
    public function successResponse($data, $code = Response :: HTTP_OK){
        return response()->json(['data'=>$data, 'site' => 2], $code);
    }
    public function errorResponse($message, $code){
        return response()->json(['error' => $message, 'site' => 2, 'code' => $code], $code);
    }
 }

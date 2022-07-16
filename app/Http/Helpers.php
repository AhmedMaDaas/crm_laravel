<?php

use Illuminate\Support\Facades\Auth;

class Helper{

    public static function createSuccessResponse($data = null,$message=null,$isLogin=false)
    {
        if($isLogin){
            $response=['success'=>true];
            $response['data']=$data;
            return $response;
        }

        $response = ['isSuccessful' => true];
        $response['hasContent']=$data ? true:false;
        $response['code']=200;
        $response['message']=$message;
        $response['detailed_error']=null;
        $response['data']=$data;

        return $response;
    }

    public static function createErrorResponse($message,$detailed_error=null,$error_code=400,$isLogin=false){
        if($isLogin){
            $response=['success'=>false];
            $response['data']=$message;
            return $response;
        }
        
        $response=['isSuccessful'=>false];
        $response['code']=$error_code;
        $response['hasContent']=false;
        $response['message']=$message;
        $response['detailed_error']=$detailed_error;
        $response['data']=null;
           return $response;
    }

    public static function filterArray($array, $allowedKeysToBeNull = []){
        $filterdArray = array_filter($array, function($value, $key) use ($allowedKeysToBeNull){
            return in_array($key, $allowedKeysToBeNull) || ($value !== NULL && $value !== '');
        }, ARRAY_FILTER_USE_BOTH);

        return $filterdArray;
    }

    public static function saveFile($file, $path){
        $imageName = uniqid() . $file->getClientOriginalName();
        $imageName = preg_replace('/\s+/', '_', $imageName);
        $file->move(public_path('storage/' . $path), $imageName);
        return asset('storage/' . $path) . '/' .$imageName;
    }

    public static function saveFileGetLinkWithName($file, $path){
        $link = Self::saveFile($file, $path);
        $pathInfo = pathinfo($link);
        $fileName = $pathInfo['filename'] . '.' . $pathInfo['extension'];
        $data = ['link' => $link, 'fileName' => $fileName];
        return $data;
    }
}
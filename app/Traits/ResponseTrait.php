<?php
/**
 * Created by PhpStorm.
 * User: Brainchild soft
 * Date: 7/31/2019
 * Time: 11:00 AM
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ResponseTrait
{
    public static function AllResponse($statusText='Error', $status=Response::HTTP_BAD_REQUEST, $message="", $url='')
    {
        return response()->json([
            'status'=>$status,
            'statusText'=>ucfirst($statusText),
            'message'=>$message,
            'url'=>$url,
        ]);

    }

    public static function UnauthenticatedResponse()
    {
        if (\request()->ajax()){
            return response()->json([
                'ok'=>false,
                'status'=>Response::HTTP_UNAUTHORIZED,
                'statusText'=>ucfirst('unauthenticated'),
                'message'=>'You Are Unauthenticated. Login Again',
            ],Response::HTTP_UNAUTHORIZED);
        }else{
            return redirect()->back()
                ->with("unauthenticated", "You Are Unauthenticated. Login Again");
        }
    }

    public static function CollectionResponse($statusText='Success', $status=200, $collection=null, $message=null){
        return $collection->additional(
            [
                'statusText'=>ucfirst($statusText),
                'status'=>$status,
                'ok'=>true,
                'message'=>$message
            ]);
    }

    public static function SingleResponse($data, $statusText='Success', $status=200, $ok = true, $message=''){
        return response()->json([
            'status'=>$status,
            'statusText'=>ucfirst($statusText),
            'ok'=>$ok,
            'data'=>$data,
            'message'=>$message
        ]);
    }

    public static function ValidationResponse($errors=[], $statusText='Validation', $status=Response::HTTP_NOT_ACCEPTABLE, $ok=false)
    {
        $message = null;
        foreach ($errors as $error){
            if(!empty($error)){
                foreach ($error as $errorItem){
                    $message .=  $errorItem .',';
                }
            }
        }
        return response()->json([
            'status'=>Response::HTTP_NOT_ACCEPTABLE,
            'statusText'=>ucfirst($statusText),
            'ok'=>$ok,
            'message'=>$message,
        ]);
    }

    public static function MakeCollectionResponse(Request $request, $list)
    {

        if (!empty($request->per_page)) {
            $list = $list->paginate($request->per_page);
        }elseif (!empty($request->page)){
            $list = $list->paginate();
        }elseif(!empty($request->take)){
            $list = $list->take($request->take)->get();
        }else{
            $list = $list->get();
        }
        return $list;
    }
}

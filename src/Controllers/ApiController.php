<?php
 /**
 * Interface based controller
 */
namespace module\roles\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller {
	
	
    protected $statusCode = IlluminateResponse::HTTP_OK;

     public function getStatusCode()
    {
        return $this->statusCode;
    }

   public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }
     public function respondSuccess($dataarray, $headers = [])
    {  
        $data['status'] = 'success';
        $data['data'] = $dataarray;
        return response()->json($data, $this->getStatusCode(), $headers);
    }
    public function respondFail($dataarray, $headers = [])
    {
         $data['status'] = 'fail';
         $data['errors'] = $dataarray;
        return response()->json($data, $this->getStatusCode(), $headers);
    }     
    public function setStatusCodeFailValidation()
    {
       // $this->statusCode = 423;
         $this->statusCode = 401;
    }
     public function setStatusCodeException()
    {
        $this->statusCode = 421;
    }
     public function setStatusCodeNotFound()
    {
        $this->statusCode = 404;
    }
    public function setStatusCodeSuccess()
    {
        $this->statusCode = 200;
    }
    public function setStatusCodeDbError()
    {
        $this->statusCode = 415;
    }

    /*
    | Image Manager for upload images 
    */

    /*public function uploadImage(Request $request, FileManager $fileManager, ImageManager $imageManager)
    {
        // Save the image directly to Cloudinary
        $file = $fileManager->saveFile($request->file('upload'), ['disk' => 'cloudinary']);

        return Response::json([
            'id'  => $file->getId(),
            'url' => $imageManager->getImageUrl($file, ['transformation' => 'small'])
        ]);
    }*/

    public function setStatusCodePendingUser()
    {
        $this->statusCode = 420;
    }
    public function SendMessage($phone,$message)
    {

      
    }

    function sendGCM($message, $id) {


        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
                'registration_ids' => array (
                        $id
                ),
                'data' => array (
                        "message" => $message
                )
        );
        $fields = json_encode ( $fields );

        $headers = array (
                'Authorization: key=' . "AIzaSyDJQGlwrL0FH8IZvilgj57DvPgBSQzhaMo",
                'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        print_r($result); 
        curl_close ( $ch );
    }

}
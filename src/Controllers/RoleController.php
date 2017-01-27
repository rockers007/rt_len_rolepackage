<?php
namespace module\roles\Controllers;

use Illuminate\Routing\Controller;
use Dingo\Api\Http\Request;
//use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use module\roles\Repositories\RoleRepository;
use module\roles\Models\Role;

class RoleController extends ApiController
{
   protected $RoleRepository;
   public function __construct(RoleRepository $RoleRepository) {
        
      $this->RoleRepository = $RoleRepository;
   }
   public function index()
   {
        try {
            $rolelist = $this->RoleRepository->getallrecords();
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);

        } catch (\Exception $e) {

            $this->setStatusCodeException();
            $data['message'] = $e->getMessage();
            return $this->respondFail($data);
        }
   }
   public function show($id)
   {
        try {

            $rolelist =  $this->RoleRepository->getRolesbyId($id);          
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);

        } catch (\Exception $e) {
            
            $this->setStatusCodeException();
            $data['message'] = $e->getMessage();
            return $this->respondFail($data);

        }
   	}
    public function store(Request $request)
    {
        try { 
            // Validation rules
            $rules = [
                'RoleName'      => ['required'],
                'RoleDesc'      => ['required'],
                'CreatedId'     => ['required'],
                'ClientId'      => ['required']
            ];

            $requestData = json_decode($request->getContent(), true);
            
            $payload = array(
                'RoleName'      =>  $requestData['RoleName'],
                'RoleDesc'      =>  $requestData['RoleDesc'],
                'CreatedId'      =>  $requestData['CreatedId'],
                'ClientId'      =>  $requestData['ClientId']
            );
            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                $messages="";
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                   if( $messages=="") $messages=$message;
                   else $messages.="\n". $message;
                }
                $this->setStatusCodeFailValidation();
                $data['message'] = $messages;
                return $this->respondFail($data);
            }

            // Create New User

            $rolelist = $this->RoleRepository->createRole($payload); 
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);

        } catch (\Exception $e) {

            $this->setStatusCodeException();
            $data['message'] = $e->getMessage();
            return $this->respondFail($data);
        }
    }
    public function update(Request $request, $role_id)
    {
        try { 
            // Validation rules
            $rules = [
                'RoleName'  => ['required'],
                'RoleDesc'  => ['required'],
                'ModifiedId' => ['required']
            ];

            $requestData = json_decode($request->getContent(), true);
            
            $payload = array(
                'RoleName'  =>  $requestData['RoleName'],
                'RoleDesc'  =>  $requestData['RoleDesc'],
                'ModifiedId' =>  $requestData['ModifiedId']
            );

            /*if(isset($requestData['imageName'])) {
               $payload['imageName'] = $requestData['imageName']; 
            }*/
            
            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                $messages="";
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                   if($messages == "") 
                    $messages = $message;
                   else 
                    $messages .= "\n".$message;
                }

                $this->setStatusCodeFailValidation();
                $data['message'] = $messages;
                return $this->respondFail($data);
            }

            $rolelist = $this->RoleRepository->updateRoles($payload, $role_id, $request,$type="all");
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);

        } catch (\Exception $e) {
            $this->setStatusCodeException();
            $data['message'] = $e->getMessage();
            return $this->respondFail($data);
        }
    }
    public function active(Request $request , $role_id)
    {
        try {
            $requestData = json_decode($request->getContent(), true);
            $payload = array('IsActive'=>$requestData['IsActive']);

            $rolelist = $this->RoleRepository->updateRoles($payload,$role_id,$request,'active');
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);
        } catch (\Exception $e) {
            $this->setStatusCodeException();
            $data['message'] =$e->getMessage();
            return $this->respondFail($data);
        }
    }
    public function delete(Request $request , $role_id)
    {
        try {
            $requestData = json_decode($request->getContent(), true);
            $payload = array('IsDelete'=>$requestData['IsDelete']);

            $rolelist = $this->RoleRepository->updateRoles($payload,$role_id,$request,'delete');
            $data['data'] = $rolelist;
            $this->setStatusCodeSuccess();
            return $this->respond($data);
        } catch (\Exception $e) {
            $this->setStatusCodeException();
            $data['message'] =$e->getMessage();
            return $this->respondFail($data);
        }
        
    }
    public function destroy($id)
    {
        try { 
            $rolelist = $this->RoleRepository->deleteRoles($id);
            if(!empty($rolelist)){
                $data['status'] = 'success';
                $m['message'] = "Role delete successfully";
                $data['errors'] = $m;
            } else {
                $data['status'] = 'fail';
                $m['message'] = "Enter valid RoleId";
                $data['errors'] = $m;
            }
            $this->setStatusCodeSuccess();
            return $this->respond($data);
        } catch (\Exception $e) {
            $this->setStatusCodeException();
            $data['message'] = $e->getMessage();
            return $this->respondFail($data);
        }
    }

}

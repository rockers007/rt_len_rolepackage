<?php

namespace module\roles\Repositories;

use Illuminate\Database\QueryException;
use module\roles\Models\Roles;
use module\roles\Exceptions\RoleException;
/**
 * Class RolesRepository
 *
 * Roles resources.
 */
class RoleRepository
{
    public function getallrecords()
    {
    	try {
            $Roleslist = Roles::all();
            return $Roleslist;
        } catch (\Exception $e) {
            throw new RoleException('Exception thrown while trying to fetch Introgallerys', 50001001);
        }
    }

    /*
    |   Get Perticular Roles by Id
    */

    public function getRolesbyId($id)
    {
       $Roleslist = Roles::find($id);

        if (empty($Roleslist)) {
            try {
                // success
            } catch (\Exception $e) { 
                throw new RoleException('Roles not found', 40400000);
            }
        }

        return $Roleslist;
    }

    /*
    |   Create new Roles
    */

    public function createRole($payload)
    {
        try {
           /*$RolesImageArray=(!isset( $payload['imageName'])) ? array() : $this->uploadBase64Image( $payload['imageName']);
            $image = (!isset( $RolesImageArray['secure_url'])) ?"" :  $RolesImageArray['secure_url'];*/

            $dataArray=array();
            $dataArray=[
                'RoleName' => $payload['RoleName'],
                'RoleDesc' => $payload['RoleDesc'],
                'ClientId' => $payload['CreatedId'],
                'ClientId' => $payload['ClientId']
            ];
            
            $newRoles = Roles::create($dataArray);
            return $newRoles;

        } catch (QueryException $e) {
            
            throw new RoleException('Exception thrown while trying to create Roles by query', 50001001);

        } catch (\Exception $e) { 
            throw new RoleException($e->getMessage(), 50001001);
        }
    }

    /*
    | Update Exiting Roles 
    */

    public function updateRoles($payload,$Roles_id, $request,$type='all')
    {
        try {
            $Roleslist = $this->getRolesbyId($Roles_id);

            // update Value
            if($type=="all")
            {
                /* $RolesImageArray=(!isset( $payload['imageName'])) ? array() : $this->uploadBase64Image( $payload['imageName']);
                $image = (!isset( $RolesImageArray['secure_url'])) ?"" :  $RolesImageArray['secure_url'];
                
                if(isset($imageArray['secure_url']) && $imageArray['secure_url']) {
                    $introgallery->imageName = $imageArray['secure_url'];
                } */

                $Roleslist->RoleName   = $payload['RoleName'];
                $Roleslist->RoleDesc   = $payload['RoleDesc'];
                $Roleslist->ModifiedId = $payload['ModifiedId'];
            }
            if($type=="active")
            {
               $Roleslist->IsActive = $payload['IsActive'];
            }
            if($type=="delete")
            {
               $Roleslist->IsDelete = $payload['IsDelete'];
            }

            $Roleslist->save();
            return $Roleslist;

        } catch (Exception $e) {
            
             throw new RoleException('Exception thrown while trying to update Roles', 50001001);
        } 
    }

    /*
    |  Delete Roles
    */ 
    public function deleteRoles($id)
    {
        try{
            $Roleslist = $this->getRolesbyId($id);
            if(!empty($Roleslist)){
                $Roleslist->delete();    
                return $Roleslist;
            } else {
                return null;
            }
            //return null;
        } catch (\Exception $e) { // @codeCoverageIgnoreStart

            throw new RoleException('Exception thrown while trying to delete Roles', 50001001);
        }
    }
}



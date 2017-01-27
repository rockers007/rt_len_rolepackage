<?php
namespace module\roles\Models;

use Illuminate\Database\Eloquent\Model;
use module\roles\Models\User;

class Roles extends Model
{
    protected $table = 'UserRoles';
    protected $primaryKey = 'Id';
    
    protected $fillable = ['Id','RoleName','RoleDesc','IsActive','IsDelete','CreatedId','ModifiedId','ClientId'];
    protected $visible = ['Id','RoleName','RoleDesc','IsActive','IsDelete','CreatedId','ModifiedId','ClientId'];
    const CREATED_AT = 'Created';
    const UPDATED_AT = 'Modified';
}
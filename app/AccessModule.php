<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessModule extends Model
{
    protected $table='access_module';
    protected $fillable=[];


    const Table_module='module';
    const Table_item='item';



    static function can($permission,$user_id){
        $item=ItemModule::item($permission);
        $userRole=UserRole::getRoles($user_id);
        if (empty($item) || count($userRole)<1)
            return 0;
        return self::permissionExists($userRole,$item);
    }
    static function permissionExists($role_id,$permission){
        return AccessModule::whereIn('role_id',$role_id)
            ->where(function ($query) use ($permission){
                $query->where('table', self::Table_item)
                    ->where('module_id',$permission->id)
                    ->orWhere('table', self::Table_module)
                    ->where('module_id',$permission->module_id);
            })
            ->exists();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table='user_role';
    protected $fillable=[];
    public function Role()
    {
        return $this->belongsTo(Roles::class,'role_id','id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    static function getRoles($id){
        return UserRole::select('id','user_id','role_id')
            ->where('user_id',$id)
            ->get()
            ->pluck('role_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemModule extends Model
{
    protected $table='item_module';
    protected $fillable=[];

    static function item($slug){
        $item=ItemModule::where('slug',$slug)
            ->select('slug','id','module_id')
            ->first();
        return $item;
    }
}

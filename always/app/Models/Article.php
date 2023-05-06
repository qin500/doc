<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded=[];

    //访问器
    public function getbdtsAttribute($value){
        return $value ? "成功" : "失败";
    }

    public function category(){
        return $this->hasOne(Category::class,'id','cid')->first();
    }
}

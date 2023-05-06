<?php


namespace App\Lib;

use App\Models\DiskManage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;




class Tool
{
    //处理图片
    /*
    @param $type 可能的值('upload','save','clean','update')
    @param $data 数组和字符串 ,字符串默认会进行正则匹配


    */
    public static function photoFactory($type, $data, $data2 = "")
    {
        if (gettype($data) == "string") {
            if ($data == "") return;
            $pattern = '/<img.*?src=[\'\"]{1}(.*?)[\'\"]{1}\s.*?>/i';
            if (preg_match_all($pattern, $data, $result_preg)) {
                $data = $result_preg[1];
            }else{
                return;
            }
        }
        if (gettype($data2) == "string" && $type == 'update') {
            if ($data2 == "") return;
            $pattern = '/<img.*?src=[\'\"]{1}(.*?)[\'\"]{1}\s.*?>/i';
            if (preg_match_all($pattern, $data2, $result_preg)) {
                $data2 = $result_preg[1];
            }else{
                $data2=[];
            }
        }

        if ($type == 'upload' || $type == "save") {
            array_walk($data, function (&$item) use ($type) {
                $item = ['path' => $item, 'type' => $type, 'uid' => auth()->id(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            });
            DiskManage::insert($data);
        } else if ($type == "clean") {
            if (!count($data)) return;
            //删除图片
            foreach ($data as $item) {
                $path = substr($item, 8);
                Storage::delete($path);
            }
            DiskManage::where(['uid' => auth()->id()])->whereIn('path', $data)->delete();
        } else if ($type == "update") {
            $del = array_diff($data, $data2);
            foreach ($del as $item) {
                $path = substr($item, 8);
                Storage::delete($path);
            }
            DiskManage::where(['uid' => auth()->id()])->whereIn('path', $del)->delete();

            //重新添加
            $intersect=array_intersect($data,$data2);
            $new_data=[];
            foreach ($data2 as $item) {
                if(in_array($item,$intersect)) continue;
                $new_data[]=['path' => $item, 'type' => "save", 'uid' => auth()->id(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            DiskManage::insert($new_data);
        }
    }



}

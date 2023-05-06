<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\True_;
use SimpleXMLElement;

class IndexController extends Controller
{
    public function index(Request $request)
    {
//    $ch=curl_init();
//    curl_setopt($ch,CURLOPT_POST,1);
//    echo "<table>";
//        for($i=1;$i<=144;$i++){
////        for($i=1415;$i<=17038;$i++){
//                $url = "http://www.iw168.cn/news/AutoCAD/{$i}.html";
//                $cont = @file_get_contents($url);
//                if($cont) {
//                    preg_match('/<h1>(.+)<\/h1>/i', $cont, $title);
//                    echo "<tr><td>{$i}</td><td>$title[1]</td><td>$url</td></tr>";
////                    preg_match('/<div id="newsContent"><div>(.+)<div id="newsEncCont">/is',$cont,$main);
//////                    Storage::put( '/save/'. $i . "." . $title[1] . ".txt",$main[1]);
////                    @file_put_contents(public_path() . '/save/'. $i . "." . $title[1] . ".txt",$main[1]);
//                }
//        }
//
//echo "</table>";
//        exit();

        $list=Article::orderBy('created_at','desc')->take(15)->get();
//        $list=self::getFirstPhoto($list);
        return view("home.index",compact("list"));
    }

    public function list()
    {
       $list= Article::paginate(20);
        return view("home.list",compact('list'));
    }

    public function article( Request $request,Article $article)
    {
        $tags=Tag::where(['aid'=>$article->id])->get();
        $keywords="";
        foreach ($tags as $item){
            $keywords .=$item->name . ",";
        }
        $keywords= rtrim($keywords,',');
        $keywords=rtrim($keywords,',');
        //获取所有的分类
       $all= Category::get(['id','pid','name']);
       $id=$article->cid;
       $closure=function($id,&$res=[])use($all,&$closure){
            foreach($all as  $item){
                if($item->id == $id){
                    $res[]=$item;
//                    echo $item->id . "------" . $item->name . "<br>";
                    //递归调用自己
                    $closure($item->pid,$res);
                }

            }
           return $res;
       };
        $top_cates=($closure($id));
        $top_cates=array_reverse($top_cates);//数组反转,true保留键名
       $article->increment('views');//自增
       //上一篇
        $article_prev=Article::where('id','<',$article->id)->orderBy("id",'desc')->first();
        $article_next=Article::where('id','>',$article->id)->orderBy("id",'asc')->first();
        return view('home.article',compact('keywords','tags','article','top_cates','article_prev','article_next'));
    }

    public function tagname(Request $request){
        if($request->get('name') !== null){
            $tags_ids=Tag::where(['name'=>$request->input('name')])->pluck("aid")->toArray();
            $list=Article::whereIn('id',$tags_ids)->paginate(20);
            return view('home.tagname',compact('list'));
        }else{
           //显示所有的tag

        }
    }

    //分类
    public function category(Request $request,Category $category){

        $list=Article::where('cid',$category->id)->paginate(30);
        return view('home.category',compact('list'));
    }

    //关键字检索
    public function search(Request $request){
        $word=$request->input('word');

        if($word == "") return redirect(route('Home::index'));
        $list= Article::where('title','like','%'. $word . '%')->orWhere('pure','like','%'. $word . '%')->paginate(20);
        return  view('home.search',compact('word','list'));
    }
    //关于我
    public function about(Request $request){
        return  view('home.about');
    }
    //关键字检索
    public function liuyan(Request $request){

        return  view('home.liuyan');
    }

    // XML网站地图
    public function sitemap(Request $request){

        $str='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $str.="<url><loc>" . (isset($_SERVER['https']) && strtoupper($_SERVER['HTTPS'] == "ON") ? "https" : "http") ."://". $_SERVER['HTTP_HOST']."</loc><priority>1</priority></url>";
        //所有的文章
        $list=Article::where('isshow',1)->get(['id','updated_at']);
        foreach ($list as $item){
            $str.="<url>";
            $str.='<loc>' . \route('Home::article',[$item]) . '</loc>';
            $str.='<priority>0.8000</priority>';
            $str.='<lastmod>' . date('Y-m-d',strtotime($item->updated_at)) . '</lastmod>';
            $str.='</url>';
        }
        $str.="</urlset>";
        return response($str,200,['content-type'=>'text/xml']);

    }
    //获取第一张图片
    public function getFirstPhoto($list){
        if(count($list)){
            //获取文章的第一幅图像
            foreach ($list as $k=> $v){
                if($v->masterpic !== ""){
                    $list[$k]->img=$v->masterpic;
                    continue;
                }
                $pattern='/<img.*?src=[\"\']?(.*?)[\"\']?\s.*?>/i';
                preg_match($pattern,$v->text,$match);
                $list[$k]->img=$match[1] ?? "https://wpcdn.qin500.com/QIN500/SUCAI/" . str_pad(random_int(1,100),3,"0",STR_PAD_LEFT) . ".jpg";
            }
        }
        return $list;
    }
}

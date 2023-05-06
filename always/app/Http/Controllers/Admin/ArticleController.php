<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiskManage;
use App\Models\Tag;
use App\Rules\CheckArticleCategoryID;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Lib;
use Illuminate\Support\Facades\Route;
class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

//        $routes = Route::getRoutes()->get();
//        $array = [];
//        foreach ($routes as $k=>$route) {
//
//                if (isset($route->action['as']))
//                    $array[] = $route->action['as'];
//
//
//        }
//        dd($array);
//
//
//        exit();
        if($request->input('type') !== null){
            if($request->input('type') == "update"){
                if($request->input('par') == "hidden" && $request->input('id') > 0){
                    $article=Article::find($request->id);
                    $article->isshow=abs(intval($article->isshow)-1);
                    $article->update();
                    return ['code'=>200];
                }
            }
        }
        //否则为查询
        if($request->input('id') !== null){
            //判断通过id,查询单条记录
            if($request->id == -1){
                $article = Article::Orderby('id','desc')->paginate(20);
            }else{
            $article = Article::where('id',$request->id)->paginate(20);
            }
        }else if($request->input('isshow') !== null){
            if($request->isshow == -1){
                $article = Article::Orderby('id','desc')->paginate(20);
            }else {
                $article = Article::where('isshow', $request->isshow)->paginate(20);
            }
        }else if($request->input('title' !== null)){
            $article = Article::where('title',"%{$request->title}%",$request->title)->paginate(20);
        }else{
            $article = Article::OrderBy('id', 'desc')->paginate(20);
        }
        $list=Article::all('id');
        return view('admin.article.index', compact('list','article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有的分类
//        $Category::where(['uid'=>auth()->id()])->get();
        $cates = Category::getcates();
        if (!$cates) {
            return redirect(route('Admin::category.create'))->withErrors("请先创建分类!!!");
        }
        //获取所有tag
//        $tags=Tag::where(['uid'=>auth()->id()])->get();
        $tags = DB::table('tags')->where('uid', auth()->id())->select('name')->distinct()->get();
        return view('admin.article.create', compact('cates', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //如果是数据修改
        $Validator = Validator::make($request->input(), [
            'title' => 'required',
            'category_id' => [new CheckArticleCategoryID()],
            'content' => 'required',
        ]);
        if ($Validator->errors()->count()) {
            return ['code' => 1, 'msg' => $Validator->errors()->first()];
        }

        //找出第一张图片
        $firstPic=$this->getFirstPic($request->input('content'));
        $article['uid'] = auth()->id();
        $article['title'] = $request->title;
        $article['cid'] = $request->category_id;
        $article['text'] = $request->input('content');
        $article['pure'] = strip_tags($request->input('content'));//纯文本
        $article['isshow'] = 1;//默认显示
        $article['masterpic'] = $firstPic;//主图
        try {
            $result = Article::create($article);
            if ($result) {
                $arr = explode(',', $request->tags);
                $tag = [];
                foreach ($arr as $k => $v) {
                    if ($v == "") continue;
                    $tag['name'] = $v;
                    $tag['uid'] = auth()->id();
                    $tag['aid'] = $result->id;
                    Tag::create($tag);
                }
            }
            $res=Lib\Sto::BaiduTS(route('Home::article',[$result]));
            session()->flash('publish-code', ['title' => $request->title . " 百度推送:" . (integer)$res['success'] . "条", 'id' => $result->id]);
            return ['code' => 0, 'msg' => '文章保存成功' ];
        } catch (\Exception $e) {
            return ['status' => 1, 'msg' => '文章保存失败,系统异常' . $e->getLine() . $e->getMessage()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $cates = Category::getcates();
        if (!$cates) {
            return redirect(route('Admin::category.create'))->withErrors("请先创建分类!!!");
        }
        //获取所有tag
//        $tags=Tag::where(['uid'=>auth()->id()])->get();
        $tags = DB::table('tags')->where('uid', auth()->id())->select('name')->distinct()->get();
        $tags_list = Tag::where(['uid' => auth()->id(), 'aid' => $article->id])->get();
        return view('admin.article.edit', compact('cates', 'tags', 'article', 'tags_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        $Validator = Validator::make($request->input(), [
            'title' => 'required',
            'category_id' => [new CheckArticleCategoryID()],
            'content' => 'required',
        ]);
        if ($Validator->errors()->count()) {
            return ['code' => 1, 'msg' => $Validator->errors()->first()];
        }
        $oldtext = $article->text;//加载旧的数据
        $nowtag = [];
        if ($request->input('tags') !== null) {
            $nowtag = explode(',', $request->input('tags'));
        }
        $tag_list = Tag::where(['uid' => auth()->id(), 'aid' => $article->id])->get();
        //找出已经存在的,就不进行删除操作了
        $xiangjiao = array_intersect($nowtag, array_column($tag_list->toArray(), 'name')); // []
        //清理数据库中不需要的tag
        Tag::where(['uid' => auth()->id(), 'aid' => $article->id])->whereNotIn('name', $xiangjiao)->delete();
        if (count($nowtag)) {
            $insert_tag = array_diff($nowtag, $xiangjiao);
            array_walk($insert_tag, function (&$v) use ($article) {
                $v = ['uid' => auth()->id(),
                    'aid' => $article->id,
                    'name' => $v,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()];
            });
            //使用批量插入
            Tag::insert($insert_tag);
        }
        try {
            //获取原理的主图
            $oldpic=$article->masterpic;
            //查看当前更新的内容中是否含有图片

            $pattern='/<img.*?src=[\"\']?(.*?)[\"\']?\s.*?>/i';
            preg_match($pattern,$request->input('content'),$match);
            if(isset($match[1])){
                $new_pic=$match[1];
            }elseif (preg_match('/\/SUCAI\//',$oldpic,$match)){
                $new_pic=$oldpic;
            }else{
                //随机图片
                $new_pic="https://wpcdn.qin500.com/QIN500/SUCAI/" . str_pad(random_int(1,100),3,"0",STR_PAD_LEFT). ".jpg";
            }

            $art = Article::find($article->id);
            $art->title = $request->input('title');
            $art->text = $request->input('content');
            $art->pure = strip_tags($request->input('content'));
            $art->cid = $request->input('category_id');
            $art->masterpic = $new_pic;//主图
            $art->isshow = 1;//默认显示

            $art->update();
            session()->flash('publish-code', ['title' => $request->title, 'id' => $article->id]);
            return ['code' => 0, 'msg' => '文章修改成功'];
        } catch (\Exception $e) {
            return ['status' => 1, 'msg' => '文章修改失败,系统异常' . $e->getMessage()];
        }

        //获取所有的tag

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            //删除tag
            Tag::where(['uid' => auth()->id(), 'aid' => $article->id])->delete();
            $article->delete();
            return ['status' => 'success', 'msg' => "删除成功", 'ids' => [$article->id]];
        } catch (\Exception $exception) {
            return ['status' => 'danger', 'msg' => '分类删除' . $exception->getMessage()];
        }
    }

    public function tuisong(){
        //获取所有未推送的文章
        $articles=Article::select('id')->where(['isshow'=>1,'bdts'=>0])->get();
        $urls=[];

        foreach ($articles as $item){
            $urls[]=\route('Home::article',['article'=>$item->id]);
        }
        $nums=0;
        if(!$articles->isEmpty()){
            $articles= $articles->toArray();
            $ids=array_column($articles,'id');
            $ids_pre=implode(",",$ids);
            $sql="update " .config('database.connections.mysql.prefix') . "articles set bdts = 1 where id in ($ids_pre)";
            DB::update(DB::raw($sql));
            $res=Lib\Sto::BaiduTS($urls);
            if(isset($res['success'])){
                $nums=$res['success'];
            }
        }
        return redirect()->back()->with(['returnresult'=>['status'=>1,'msg'=>'百度推送' . $nums . "条"]]);
    }


    //获取第一张图片
    private function getFirstPic($cont){
        $pattern='/<img.*?src=[\"\']?(.*?)[\"\']?\s.*?>/i';
        preg_match($pattern,$cont,$match);
        return $match[1] ?? "https://wpcdn.qin500.com/QIN500/SUCAI/" . str_pad(random_int(1,100),3,"0",STR_PAD_LEFT) . ".jpg";
    }

}

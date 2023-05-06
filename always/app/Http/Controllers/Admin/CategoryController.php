<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCategoryPID;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cates=Category::getcates();
        return view('admin.category.index',['cates'=>$cates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates=Category::getcates();
        return view('admin.category.create',['cates'=>$cates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Validator=Validator::make($request->input(),
            ['name'=>'required'],
            ['name.required'=>'名称不能为空']);

        if($Validator->errors()->count()){
            return back()->withErrors($Validator->errors()->first());
        }
        $pid=$request->pid;
        if($pid !== "0"){
            $cat=Category::find($pid);
            if(!$cat){
                return back()->withErrors("添加失败,系统错误");
            }
        }

        $cate=new Category();
        $cate->pid=(integer)$pid;
        $cate->uid=auth()->id();
        $cate->name=$request->name;
        $result=$cate->save();
        return redirect(route('Admin::category.index'))->with(['returnresult'=>['status'=>$result,'msg'=>'分类添加']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $cates=Category::getcates();
        return view('admin.category.edit',compact('category','cates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category,StoreCategoryPID $request)
    {
        if($category->uid !== auth()->id()){
            return [];
        }
        if($request->isMethod('PUT')){
            $input = $request->except(['_token']);
            $input['uid'] = auth()->id();
            $result = $category->update($input);
            return redirect(route('Admin::category.index'))->with(['returnresult' => ['status' => $result, 'msg' => '分类修改']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $ids= Category::getChildsIds($category->id);
        try{
            Category::where(['uid'=>auth()->id()])->whereIn('id',$ids)->delete();
            return ['status'=>'success','msg'=>"分类删除成功",'ids'=>$ids];
        }catch (\Exception $e){
            return ['status'=>'danger','msg'=>'分类删除' . $e->getMessage()];
        }

    }
}

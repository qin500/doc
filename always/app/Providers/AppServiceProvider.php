<?php

namespace App\Providers;

use App\Lib\Sto;
use App\Models\SysOption;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        $ug = strtolower($_SERVER['HTTP_USER_AGENT']);
        $ug = "aaa";
        if ((strrpos($ug, "python") !== false) || (strrpos($ug, "curl") !== false) || (strrpos($ug, "httpclient") !== false)) {
            header("Content-Disposition: attachment; filename=error.txt");
            header("Content-Type: application/octet-stream");
            echo "服务器遇到错误,暂时无法处理请求.";
            exit();
        }
        if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https")) {
            \URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.simple-default');
        Schema::defaultStringLength(191);
        $data['start_time'] = microtime(true);
        //查询最新文章10篇
        $data['nowart'] = DB::table('articles')->orderBy('created_at', 'desc')->take(8)->get();
        $data['tag'] = DB::table('tags')->select('name')->distinct()->get();
        $data['art_count'] = DB::table('articles')->get()->count();
        $data['cat_count'] = DB::table('categories')->get()->count();
        $data['myinfo'] = DB::table('my_users')->first();
        $data['myinfo'] = json_decode($data['myinfo']->other);

        $all_set = SysOption::select(["key", "val"])->get()->toArray();
        $peizi = [];
        if (count($all_set)) {
            $peizi = array_reduce($all_set, function ($cal, $item) {
                $tmp[$item['key']] = $item['val'];
                if ($cal == null) {
                    return $tmp;
                }
                return array_merge($cal, $tmp) ?? $tmp;
            });
        }
        $data['peizi'] = $peizi;

//        view()->composer(['home.index','home.article','home.list'], function ($view) use($data) {});
        view()->composer('*', function ($view) use ($data) {
            $view->with('data', $data);
        });
    }
}

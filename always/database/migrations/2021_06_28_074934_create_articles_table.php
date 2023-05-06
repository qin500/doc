<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->startingValue(1000)->comment('设置起始id100');
            $table->integer('uid')->nullable()->comment('用户id');
            $table->string('title',120)->nullable()->comment('标题');
            $table->longText('text')->nullable()->comment('文章内容');
            $table->string('masterpic',250)->nullable()->comment('文章主图');
            $table->longText('pure')->nullable()->comment('文章内容被剥离HTML标签');
            $table->integer('cid')->nullable()->comment('分类id');
            $table->integer('ishow')->nullable()->default(1)->comment('1显示0隐藏');
            $table->integer('views')->nullable()->default(0)->comment('浏览次数');
            $table->integer('zan')->default(0)->comment('文章赞');
            $table->integer('bdts')->default(0)->comment('文章赞');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

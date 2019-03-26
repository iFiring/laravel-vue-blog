<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->timestamps();
            $table->string('cover')->nullable(); // 封面图
            $table->string('title');// 文章标题
            $table->string('description'); // 文章描述
            $table->longText('content_raw')->nullable(); // 元文章
            $table->longText('content_html')->nullable(); // H5格式文章
            $table->string('title_en')->nullable();// 英文标题
            $table->string('description_en')->nullable(); // 英文描述
            $table->longText('content_raw_en')->nullable(); // 英文版元文章
            $table->longText('content_html_en')->nullable(); // 英文版H5格式文章
            $table->boolean('is_draft')->default(1); // 草稿
            $table->integer('visitor')->default(0); // 浏览数
            $table->integer('comment')->default(0); // 评论数
            $table->integer('sorts_id')->nullable(); // 所属分类
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

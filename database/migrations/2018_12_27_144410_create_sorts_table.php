<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->unique(); // 分类名称
            $table->string('name_en')->nullable(); // 英文分类名称
            $table->integer('article_num')->default(0); // 对应的文章数
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sorts');
    }
}

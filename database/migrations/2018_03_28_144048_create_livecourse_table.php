<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivecourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_course', function (Blueprint $table) {
            $table->increments('id');
            $table->string('live_course',32)->notNull()->comment('直播课程名称');
            $table->integer('stream_id')->notNull()->comment('所属直播流');
            $table->string('cover_img',100)->notNull()->default('')->comment('封面图');
            $table->string('live_desc')->notNull()->default('')->comment('描述');
            $table->integer('start_time')->notNull()->comment('开始时间');
            $table->integer('end_time')->notNull()->comment('结束时间');
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
        Schema::dropIfExists('live_course');
    }
}

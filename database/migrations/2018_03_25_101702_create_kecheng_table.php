<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKechengTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //专业表
        // Schema::create('profession', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('profession_name',32)->notNull()->comment('名称');
        //     $table->string('profession_desc')->notNull()->default('')->comment('描述');
        //     $table->string('cover_img',100)->notNull()->default('')->comment('封面图');
        //     $table->timestamps();
        // });
        //  //课程表
        // Schema::create('course', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('course_name',32)->notNull()->comment('名称');
        //     $table->integer('profession_id')->notNull()->comment('所属专业的ID');
        //     $table->string('course_desc')->notNull()->default('')->comment('描述');
        //     $table->decimal('course_price',9,2)->notNull()->default(0)->comment('价格');
        //     $table->string('cover_img',100)->notNull()->default('')->comment('封面图');
        //     $table->timestamps();
        // });
         //课时表
        Schema::create('lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lesson_name',32)->notNull()->comment('名称');
            $table->integer('course_id')->notNull()->comment('所属课程的ID');
            $table->string('lesson_desc')->notNull()->default('')->comment('描述');
            $table->string('cover_img',100)->notNull()->default('')->comment('封面图');
            $table->integer('lesson_length')->notNull()->default(10)->comment('课时的长度');
            $table->string('teacher_name',16)->notNull()->comment('讲师名称');
            $table->string('video_address',100)->notNull()->default('')->comment('视频地址');
            $table->integer('status')->notNull()->default(1)->comment('状态');
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
        Schema::dropIfExists('profession');
        Schema::dropIfExists('course');
        Schema::dropIfExists('lesson');
    }
}

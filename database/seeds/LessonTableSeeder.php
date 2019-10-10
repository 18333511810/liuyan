<?php

use Illuminate\Database\Seeder;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lesson')->insert([
        	[
        		'lesson_name'=>'PHP核心编程',
        		'course_id'=>1,
        		'teacher_name'=>'李莫愁'
        	],
        	[
        		'lesson_name'=>'TP项目实战',
        		'course_id'=>2,
        		'teacher_name'=>'张三丰'
        	],
        	[
        		'lesson_name'=>'JS编程',
        		'course_id'=>3,
        		'teacher_name'=>'李白'
        	],
        	[
        		'lesson_name'=>'Linux环境安装',
        		'course_id'=>4,
        		'teacher_name'=>'刘备被'
        	],

        ]);
    }
}

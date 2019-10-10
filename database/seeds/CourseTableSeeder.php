<?php

use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course')->insert([
        	[
        		'course_name'=>'PHP核心编程',
        		'profession_id'=>1,
        		'course_price'=>1234.56
        	],
        	[
        		'course_name'=>'MySQL数据库',
        		'profession_id'=>1,
        		'course_price'=>2234.56
        	],
        	[
        		'course_name'=>'LAMP环境安装',
        		'profession_id'=>2,
        		'course_price'=>234.56
        	],
        	[
        		'course_name'=>'TP5项目实战',
        		'profession_id'=>3,
        		'course_price'=>4234.56
        	],

        ]);
    }
}

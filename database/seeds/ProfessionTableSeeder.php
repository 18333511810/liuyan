<?php

use Illuminate\Database\Seeder;

class ProfessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profession')->insert([
        	[
        		'profession_name'=>'PHP高级工程师',
        		'profession_desc'=>'高新就业的课程'
        	],
        	[
        		'profession_name'=>'HTML5&全栈',
        		'profession_desc'=>'高新就业的课程'
        	],
        	[
        		'profession_name'=>'linux高级运维',
        		'profession_desc'=>'高新就业的课程'
        	],
        ]);
    }
}

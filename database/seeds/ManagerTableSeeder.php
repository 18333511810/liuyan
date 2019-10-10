<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('zh_CN');
        for($i=0;$i<50;$i++){
        	//填充数据
        	DB::table('manager')->insert([
        		'username'=>$faker->name,
        		'password'=>bcrypt('123456'),
        		'email'=>$faker->email,
        		'phone'=>$faker->phoneNumber,
        		'city'=>$faker->city,
        		'address'=>$faker->address,
        		'company'=>$faker->company,
        		'intro'=>$faker->catchPhrase,
        		'face'=>$faker->imageUrl,
        		'role_id'=>rand(1,2)
        	]);
        }
    }
}

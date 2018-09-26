<?php

use Illuminate\Database\Seeder;
use App\User;
class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $book = $user->books()->create([
            'name'=> str_random(10)
        ]);
    }
}

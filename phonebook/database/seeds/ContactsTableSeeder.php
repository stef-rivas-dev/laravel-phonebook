<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete table with foreign key constraint
        DB::table('contacts')->delete();

        // Get all user data
        $users = User::all()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $userId = $faker->randomElement($users);

            Contact::create([
                'user_id' => $userId,
                'phone_number' => $faker->e164PhoneNumber,
                'label' => $faker->name,
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $administrator = new \App\User;
        $administrator->username = "administrator";
        $administrator->name = "Site Administrator";
        $administrator->email = "administrator@wanoja.test";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("wanoja");
        $administrator->avatar = "saat-ini-tidak-ada-file.png";
        $administrator->address = "Sarmili, Bintaro, Tangerang Selatan";

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}

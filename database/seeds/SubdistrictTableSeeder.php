<?php

use Illuminate\Database\Seeder;

class SubdistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $url_city = "https://pro.rajaongkir.com/api/city?key=d1e0da7453eb42f959f5b3072a94a21c";
        $json_str = file_get_contents($url_city);
        $json_obj = json_decode($json_str);
        $cities = [];
        foreach($json_obj->rajaongkir->results as $city){
            $cities[] = [
                'id'            => $city->city_id,
                'province_id'   => $city->province_id,
                'city_name'     => $city->city_name,
                'type'          => $city->type,
                'postal_code'   => $city->postal_code,
            ];
        }
        DB::table('cities')->insert($cities);
    }
}

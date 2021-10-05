<?php

use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Province;
use App\City;
class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach ($daftarProvinsi as $provinceRow) {
            Province::create([
                'provinsi_id' => $provinceRow['province_id'],
                'nama' => $provinceRow['province']
            ]);
            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
            foreach ($daftarKota as $cityRow) {
                City::create([
                    'provinsi_id' => $provinceRow['province_id'],
                    'kota_id' => $cityRow['city_id'],
                    'nama' => $cityRow['city_name']
                ]);
            }
        }
    }
}

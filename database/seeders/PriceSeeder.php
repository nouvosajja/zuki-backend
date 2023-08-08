<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::create([
            'waktu' => '3 hari khusus cuci setrika',
            'paket_id' => 1,
            'harga' => 12000,
        ]);

        Price::create([
            'waktu' => '3 hari khusus cuci',
            'paket_id' => 1,
            'harga' => 9000,
        ]);

        Price::create([
            'waktu' => '3 hari khusus setrika',
            'paket_id' => 1,
            'harga' => 6000,
        ]);

        Price::create([
            'waktu' => '3 hari sepatu',
            'paket_id' => 1,
            'harga' => 9000,
        ]);

        Price::create([
            'waktu' => '3 hari khusus lainya',
            'paket_id' => 1,
            'harga' => 12000,
        ]);

        Price::create([
            'waktu' => '12 jam khusus cuci setrika',
            'paket_id' => 2,
            'harga' => 20000,
        ]);

        Price::create([
            'waktu' => '1 hari khusus cuci',
            'paket_id' => 2,
            'harga' => 17000,
        ]);

        Price::create([
            'waktu' => '1 hari khusus setrika',
            'paket_id' => 2,
            'harga' => 10000,
        ]);

        Price::create([
            'waktu' => '1 hari sepatu',
            'paket_id' => 2,
            'harga' => 17000,
        ]);

        Price::create([
            'waktu' => '1 hari khusus lainya',
            'paket_id' => 2,
            'harga' => 20000,
        ]);
    }
}

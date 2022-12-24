<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspirationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aspiration::query()->create([
            'aspirator' => 'Fulan',
            'nik' => 3217072561789327,
            'story' => 'ini detail',
            'photo' => 'http://ini-photo.com/fulan'
        ]);
        Aspiration::query()->create([
            'aspirator' => 'Fulanah',
            'nik' => 3217072561768291,
            'story' => 'ini detail',
            'photo' => 'http://ini-photo.com/fulanah'
        ]);
    }
}

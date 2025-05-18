<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'currency_symbol', 'value' => 'XOF'],
            ['key' => 'site_description', 'value' => 'This is an awesome site!'],
            ['key' => 'site_email', 'value' => 'info@bokitgrill.online'],
            ['key' => 'site_name', 'value' => 'Bokit Grill'],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                attributes: [
                    'key' => $setting['key']
                ],
                values: [
                    'value' => $setting['value']
                ]
            );
        }
    }
}

<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()

    {
        Company::insert([
            ['id_company' => 'EL-00', 'name' => 'Company A', 'data' => '{}', 'photo' => null, 'work_time' => '08:00 - 17:00'],
        ]);
    }

}

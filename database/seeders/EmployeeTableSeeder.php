<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Emplyee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory(10)->create();
    }
}

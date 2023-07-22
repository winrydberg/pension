<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'System Administration'
        ]);

         Department::create([
            'name' => 'Claim Entry'
        ]);

        Department::create([
            'name' => 'Audit'
        ]);

         Department::create([
            'name' => 'Accountants / Scheme Admins'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ClaimState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClaimStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //1
        // ClaimState::create([
        //     'name' => 'Not Processed',
        //     'cssclass' => 'badge rounded-pill bg-dark'
        // ]);
        // //2
        // ClaimState::create([
        //     'name' => 'Processed',
        //     'cssclass' => 'badge rounded-pill bg-gray'
        // ]);
        // //3
        // ClaimState::create([
        //     'name' => 'Not Audited',
        //     'cssclass' => 'badge rounded-pill bg-primary'
        // ]);
        // //4
        // ClaimState::create([
        //     'name' => 'Audited',
        //     'cssclass' => 'badge rounded-pill bg-info'
        // ]);
        // //5
        // ClaimState::create([
        //     'name' => 'Not Received',
        //     'cssclass' => 'badge rounded-pill bg-light'
        // ]);

        // //6
        // ClaimState::create([
        //     'name' => 'Received',
        //     'cssclass' => 'badge rounded-pill bg-success'
        // ]);

        // //7
        // ClaimState::create([
        //     'name' => 'All Paid',
        //     'cssclass' => 'badge rounded-pill bg-secondary'
        // ]);

        // //8
        // ClaimState::create([
        //     'name' => 'Partial Paid',
        //     'cssclass' => 'badge rounded-pill bg-primary'
        // ]);

        // //9
        // ClaimState::create([
        //     'name' => 'Invalid',
        //     'cssclass' => 'badge rounded-pill bg-danger'
        // ]);
        //10
        ClaimState::create([
            'name' => 'Transfered To Bank',
            'cssclass' => 'badge rounded-pill bg-warning'
        ]);
    }
}

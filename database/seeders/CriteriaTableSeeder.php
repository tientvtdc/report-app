<?php

namespace Database\Seeders;

use App\Models\Criterion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Criterion::create([
            'code' => 1,
            'content' => 'Content of criterion 1',
        ]);

        Criterion::create([
            'code' => 2,
            'content' => 'Content of criterion 2',
        ]);
    }
}

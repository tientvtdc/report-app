<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Program::create([
            'program_vi_title' => 'Công nghệ thông tin',
        ]);
        Program::create([
            'program_vi_title' => 'Công nghệ thông tin Nhật Bản (TFT)',
        ]);
        Program::create([
            'program_vi_title' => 'Thiết kế đồ hoạ',
        ]);
        Program::create([
            'program_vi_title' => 'Mạng máy tính',
        ]);
    }
}

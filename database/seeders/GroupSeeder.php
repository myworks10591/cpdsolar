<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run()
    {
        // Inserting multiple groups
        Group::insert([
            ['name' => 'Group 1'],
            ['name' => 'Group 2'],
            ['name' => 'Group 3'],
        ]);
    }
}
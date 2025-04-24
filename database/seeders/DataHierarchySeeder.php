<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataHierarchy;


class DataHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ramesh = DataHierarchy::create(['name' => 'Ramesh']);
        DataHierarchy::create(['name' => 'Gaurav', 'parent_id' => $ramesh->id]);
        DataHierarchy::create(['name' => 'Shalu', 'parent_id' => $ramesh->id]);
        DataHierarchy::create(['name' => 'Deepu', 'parent_id' => $ramesh->id]);
    
        DataHierarchy::create(['name' => 'Amit']);
        DataHierarchy::create(['name' => 'Sham Lal']);
        DataHierarchy::create(['name' => 'Kapil']);
        DataHierarchy::create(['name' => 'Prem Chopra']);
    }
}

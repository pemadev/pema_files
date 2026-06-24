<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class FixBusinessSortOrderSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['migas', 'agroindustri', 'jasa'];
        
        foreach ($categories as $cat) {
            $items = Business::where('category', $cat)->orderBy('id')->get();
            $index = 0;
            foreach ($items as $item) {
                $item->update(['sort_order' => $index]);
                $index++;
            }
            $this->command->info($cat . ': ' . $items->count() . ' items fixed');
        }
        
        $this->command->info('Sort order fix completed!');
    }
}

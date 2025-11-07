<?php

namespace App\Console\Commands;

use App\Models\Animal;
use App\Models\Daily_creature;
use App\Models\Plant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailyCreature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-creature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $animals = Animal::limit(200)->get()->map(function ($a) {
            $a->type = 'animal';
            return $a;
        });

        $plants = Plant::limit(200)->get()->map(function ($p) {
            $p->type = 'plant';
            return $p;
        });

        $items = $animals->concat($plants);

        $choosen = $items->random();
        Daily_creature::create([
            "creature_id" => $choosen["id"],
            "is_plant" => $choosen->type === 'plant',
        ]);
        return Command::SUCCESS;
    }
}

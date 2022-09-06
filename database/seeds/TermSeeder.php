<?php

use Illuminate\Database\Seeder;
use App\Models\Term;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Term::create([
            'type' => 'Terms(English)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Terms(Spanish)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Terms(French)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Terms(Italian)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Terms(Russian)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Terms(German)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(English)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(Spanish)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(French)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(Italian)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(Russian)',
            'description' => '',
        ]);
        Term::create([
            'type' => 'Conditions(German)',
            'description' => '',
        ]);
    }
}

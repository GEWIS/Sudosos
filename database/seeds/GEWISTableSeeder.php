<?php

use Illuminate\Database\Seeder;

class GEWISTableSeeder extends Seeder
{
    protected $connection = 'mysql_gewisdb';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        App\Models\GEWIS\Member::truncate();
        App\Models\GEWIS\Organ::truncate();
        App\Models\GEWIS\OrganMember::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        App\Models\GEWIS\Member::create([
            'lidnr' => 6494,
            'email' => 'sjaluijten@gmail.com',
            'lastName' => 'Luijten',
            'middleName' => '',
            'initials' => 'S.J.A.',
            'firstName' => 'Stefan',
            'gender' => 'M',
            'generation' => 2011,
            'type' => 'lid',
            'changedOn' => '2017-07-18',
            'birth' => '2017-03-04',
            'expiration' => '2019-07-18',
            'paid' => 1,
            'supremum' => 'test',
            'iban' => 'NL58RABO0106414704',
        ]);

        factory(App\Models\GEWIS\Organ::class, 10)->create();
        factory(App\Models\GEWIS\OrganMember::class,3)->create();

    }
}

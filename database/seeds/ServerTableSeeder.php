<?php

use Illuminate\Database\Seeder;

class ServerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servers')->insert([
            'name' => 'ConvertKit',
            'slug' => 'convertkit',
            'api_uri' => 'https://api.convertkit.com/v3/'
        ]);

        DB::table('servers')->insert([
            'name' => 'GetResponse',
            'slug' => 'getresponse',
            'api_uri' => 'https://api.getresponse.com/v3'
        ]);

        DB::table('servers')->insert([
            'name' => 'MailWizz',
            'slug' => 'mailwizz',
            'api_uri' => null
        ]);

        DB::table('servers')->insert([
            'name' => 'Predator',
            'slug' => 'predator',
            'api_uri' => null
        ]);

        DB::table('servers')->insert([
            'name' => 'Sendlane',
            'slug' => 'sendlane',
            'api_uri' => '/api/v1/list-subscriber-add'
        ]);

        DB::table('servers')->insert([
            'name' => 'The Conversion Pros',
            'slug' => 'theconversionpros',
            'api_uri' => 'https://api.theconversionpros.com/tcp-customized-form/rpc/?method=contact.add&params='
        ]);
    }
}

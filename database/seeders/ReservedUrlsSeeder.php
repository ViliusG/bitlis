<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReservedUrlsSeeder extends Seeder
{
    public function run(): void
    {
        $reservedUrls = ['iks', 'intellikid', 'intellikidsystems', 'iksystems', 'admin'];

        $reservedUrlsToInsert = Arr::map($reservedUrls, function($url) {
            return ['reserved_url' => $url];
        });

        DB::table('reserved_urls')->insert($reservedUrlsToInsert);
    }
}

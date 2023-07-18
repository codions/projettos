<?php

namespace Database\Seeders\Demo;

use App\Models\Doc;
use App\Models\DocPage;
use App\Models\DocVersion;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $byData = [
            'user_id' => User::inRandomOrder()->first()->id,
            'project_id' => Project::inRandomOrder()->first()->id,
        ];

        Doc::factory()->count(5)->create($byData)->each(function ($doc) use ($byData) {

            $versions = DocVersion::factory()->count(2)->create(array_merge($byData, ['doc_id' => $doc->id]));

            $versions->each(function ($version) use ($doc, $byData) {

                $pages = DocPage::factory()->count(5)->create(array_merge($byData, [
                    'doc_id' => $doc->id,
                    'version_id' => $version->id,
                ]));

                $pages->each(function ($page) use ($doc, $version, $byData) {
                    DocPage::factory()->count(10)->create(array_merge($byData, [
                        'doc_id' => $doc->id,
                        'version_id' => $version->id,
                        'parent_id' => $page->id,
                    ]));
                });
            });
        });
    }
}

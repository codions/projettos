<?php

use App\Mail\Admin\RoadmapVersionOutOfDate;
use App\Services\SystemChecker;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use function Pest\Laravel\artisan;

beforeEach(function () {
    GeneralSettings::fake(['send_notifications_to' => [['name' => 'codions.io', 'email' => 'info@codions.io']]]);
});

test('version command send emails if version is out of date', function () {
    $this->mock(SystemChecker::class, function (MockInterface $mock) {
        $mock->shouldReceive('isOutOfDate')->once()->andReturn(true);
    });

    artisan('roadmap:version')->run();

    Mail::assertQueued(RoadmapVersionOutOfDate::class);
});

test('version command wont send emails if version is up to date', function () {
    $this->mock(SystemChecker::class, function (MockInterface $mock) {
        $mock->shouldReceive('isOutOfDate')->once()->andReturn(false);
    });

    artisan('roadmap:version')->run();

    Mail::assertNotQueued(RoadmapVersionOutOfDate::class);
});

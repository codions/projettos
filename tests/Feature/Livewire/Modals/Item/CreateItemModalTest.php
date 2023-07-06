<?php

use App\Http\Livewire\Modals\Item\CreateItemModal;
use App\Settings\GeneralSettings;
use Livewire\Livewire;

test('A user can not submit item if they need to verify email address', function () {
    createAndLoginUser(['email_verified_at' => null]);

    app(GeneralSettings::class)->users_must_verify_email = true;

    Livewire::test(CreateItemModal::class)
        ->assertSee('Before proceeding, please check your email for a verification link');
});

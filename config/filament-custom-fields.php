<?php

use Codions\FilamentCustomFields\Resources\CustomFieldResource;
use Codions\FilamentCustomFields\Resources\CustomFieldResponseResource;

return [
    'resources' => [
        CustomFieldResource::class,
        CustomFieldResponseResource::class,
    ],
    'models' => [
        \app\Models\Project::class => 'Project',
        \app\Models\Item::class => 'Item',
        \app\Models\Ticket::class => 'Ticket',
        \app\Models\User::class => 'User',
    ],
    'navigation_group' => 'Settings',
    'custom_fields_label' => 'Custom Fields',
    'custom_field_responses_label' => 'Custom Fields Responses',
];

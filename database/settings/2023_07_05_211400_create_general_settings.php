<?php

use App\Enums\InboxWorkflow;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        // General
        $defaultBoards = [];

        foreach (['Under review', 'Planned', 'In progress', 'Live', 'Closed'] as $defaultBoard) {
            $defaultBoards[] = [
                'title' => $defaultBoard,
                'visible' => true,
                'sort_items_by' => 'popular',
            ];
        }

        $this->migrator->add('general.default_boards', $defaultBoards);
        $this->migrator->add('general.board_centered', false);
        $this->migrator->add('general.create_default_boards', true);
        $this->migrator->add('general.show_projects_sidebar_without_boards', true);
        $this->migrator->add('general.allow_general_creation_of_item', true);
        $this->migrator->add('general.dashboard_items', []);
        $this->migrator->add('general.welcome_text', 'Welcome to our roadmap!');
        $this->migrator->add('general.send_notifications_to', []);
        $this->migrator->add('general.enable_item_age', false);
        $this->migrator->add('general.select_board_when_creating_item', false);
        $this->migrator->add('general.select_project_when_creating_item', false);
        $this->migrator->add('general.block_robots', false);
        $this->migrator->add('general.project_required_when_creating_item', false);
        $this->migrator->add('general.board_required_when_creating_item', false);
        $this->migrator->add('general.custom_scripts');
        $this->migrator->add('general.inbox_workflow', InboxWorkflow::WithoutBoardAndProject);
        $this->migrator->add('general.show_voter_avatars', false);
        $this->migrator->add('general.users_must_verify_email', false);
        $this->migrator->add('general.enable_changelog', false);
        $this->migrator->add('general.show_changelog_author', true);
        $this->migrator->add('general.show_changelog_related_items', true);
        $this->migrator->add('general.disable_file_uploads', false);
        $this->migrator->add('general.excluded_matching_search_words', [
            'the', 'it', 'that', 'when', 'how', 'this', 'true', 'false', 'is', 'not', 'well', 'with', 'use', 'enable', 'of', 'for', 'to',
        ]);
        $this->migrator->add('general.profanity_words', ['fuck', 'asshole', 'dick', 'screw you']);
        $this->migrator->add('general.show_github_link', false);
        $this->migrator->addEncrypted('general.password', '');

        $this->migrator->add('general.ticket_statuses', [
            'open' => [
                'label' => 'Open',
                'description' => 'The ticket has been registered and is awaiting attention.',
            ],

            'in_progress' => [
                'label' => 'In Progress',
                'description' => 'The ticket is being analyzed and worked on by the support team.',
            ],

            'waiting_for_information' => [
                'label' => 'Waiting for Information',
                'description' => 'Waiting for a response or additional information from the customer.',
            ],

            'on_hold' => [
                'label' => 'On Hold',
                'description' => 'The ticket has been temporarily paused, waiting for the resolution of an issue or external dependency.',
            ],

            'escalated' => [
                'label' => 'Escalated',
                'description' => 'The ticket has been forwarded to a higher-level or specialized team.',
            ],

            'awaiting_approval' => [
                'label' => 'Awaiting Approval',
                'description' => 'An action or solution requires approval before proceeding.',
            ],

            'resolved' => [
                'label' => 'Resolved',
                'description' => 'The issue has been resolved, and the ticket is closed.',
            ],

            'closed' => [
                'label' => 'Closed',
                'description' => 'The ticket has been finalized and requires no further action.',
            ],

            'cancelled' => [
                'label' => 'Cancelled',
                'description' => 'The ticket has been cancelled for a specific reason.',
            ],

            'reopened' => [
                'label' => 'Reopened',
                'description' => 'A previously closed or resolved ticket has been reopened due to recurring issues or dissatisfaction with the provided solution.',
            ],
        ]);

        $this->migrator->add('general.statuses_enabled_for_change_by_ticket_owner', ['closed']);
    }
}

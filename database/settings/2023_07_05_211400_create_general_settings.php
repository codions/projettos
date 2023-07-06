<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use App\Enums\InboxWorkflow;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        // General
        $defaultBoards = [];

        foreach (['Under review', 'Planned', 'In progress', 'Live', 'Closed'] as $defaultBoard) {
            $defaultBoards[] = [
                'title'         => $defaultBoard,
                'visible'       => true,
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
            'the', 'it', 'that', 'when', 'how', 'this', 'true', 'false', 'is', 'not', 'well', 'with', 'use', 'enable', 'of', 'for', 'to'
        ]);
        $this->migrator->add('general.profanity_words', ['fuck', 'asshole', 'dick', 'screw you']);
        $this->migrator->add('general.show_github_link', false);
        $this->migrator->addEncrypted('general.password', '');

        // Colors
        $this->migrator->add('colors.favicon', null);
        $this->migrator->add('colors.fontFamily', "Nunito");
        $this->migrator->add('colors.logo', null);
        $this->migrator->add('colors.primary', '#2563EB');
    }
}

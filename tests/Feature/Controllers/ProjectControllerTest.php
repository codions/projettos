<?php

use App\Enums\UserRole;
use App\Models\Board;
use App\Models\Item;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Sequence;
use function Pest\Laravel\get;

it('renders the page', function () {
    $project = Project::factory()->create();

    get(route('projects.home', $project))->assertOk();
});

it('includes the boards', function () {
    $project = Project::factory()->has(Board::factory(5))->create();

    get(route('projects.home', $project))
        ->assertSeeInOrder(Board::all()->pluck('title')->toArray())
        ->assertDontSee('There are no boards in this project');
});

it('includes the items', function () {
    $project = Project::factory()
        ->has(
            Board::factory(5)
                ->has(Item::factory(10))
        )
        ->create();

    get(route('projects.home', $project))->assertSeeInOrder(Item::all()->pluck('title')->toArray());
});

it('includes votes for items', function () {
    $project = Project::factory()
        ->has(
            Board::factory(5)
                ->has(Item::factory(10)->state(['total_votes' => 2]))
        )
        ->create();

    get(route('projects.home', $project))->assertSeeInOrder(Item::withCount('votes')->get()->pluck('total_votes')->toArray());
});

it('shows note if project has no boards', function () {
    $project = Project::factory()->create();

    get(route('projects.home', $project))->assertSee('There are no boards in this project');
});

test('view has breadcrumbs', function () {
    $project = Project::factory()->create();

    get(route('projects.home', $project))->assertSeeInOrder(['Dashboard', $project->title]);
});

test('pinned items are at the top', function () {
    $project = Project::factory()
        ->has(
            Board::factory()
                ->has(
                    Item::factory(2)->state(new Sequence(
                        ['title' => 'item 1', 'pinned' => false, 'total_votes' => 10],
                        ['title' => 'item 2', 'pinned' => true, 'total_votes' => 1]
                    ))
                )
        )->create();

    get(route('projects.home', $project))->assertSeeInOrder(['item 2', 'item 1']);
});

test('items are sorted by vote count', function () {
    $project = Project::factory()
        ->has(
            Board::factory()
                ->has(
                    Item::factory(2)->state(new Sequence(
                        ['title' => 'item 1', 'total_votes' => 1],
                        ['title' => 'item 2', 'total_votes' => 10]
                    ))
                )
        )->create();

    get(route('projects.home', $project))->assertSeeInOrder(['item 2', 'item 1']);
});

test('private items are not visible for users', function (UserRole $userRole, bool $shouldBeVisible) {
    $project = Project::factory()
        ->has(
            Board::factory()
                ->has(
                    Item::factory(2)->state(new Sequence(
                        ['title' => 'item 1', 'private' => false],
                        ['title' => 'item 2', 'private' => true]
                    ))
                )
        )->create();

    createAndLoginUser(['role' => $userRole]);

    get(route('projects.home', $project))
        ->assertSeeText('item 1')
        ->{$shouldBeVisible ? 'assertSeeText' : 'assertDontSeeText'}('item 2');
})->with([
    [UserRole::User, false],
    [UserRole::Employee, true],
    [UserRole::Admin, true],
]);

test('user can not view private project', function (?UserRole $userRole, int $expectedStatusCode) {
    $project = Project::factory()->private()->create();

    createAndLoginUser(['role' => $userRole]);

    get(route('projects.home', $project))->assertStatus($expectedStatusCode);
})->with([
    [UserRole::User, 404],
    [UserRole::Employee, 200],
    [UserRole::Admin, 200],
]);

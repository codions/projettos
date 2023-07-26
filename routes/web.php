<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordProtectionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemEmailUnsubscribeController;
use App\Http\Controllers\MentionSearchController;
use App\Http\Controllers\PublicUserController;
use App\Http\Livewire\Docs\Builder as DocsBuilder;
use App\Http\Livewire\Docs\Index as DocsIndex;
use App\Http\Livewire\Items\Show as ItemsShow;
use App\Http\Livewire\Projects\Board as ProjectBoard;
use App\Http\Livewire\Projects\Boards as ProjectBoards;
use App\Http\Livewire\Projects\Changelog\Index as ChangelogIndex;
use App\Http\Livewire\Projects\Changelog\Show as ChangelogShow;
use App\Http\Livewire\Projects\Docs as ProjectDocs;
use App\Http\Livewire\Projects\Faqs as ProjectFaqs;
use App\Http\Livewire\Projects\Home as ProjectHome;
use App\Http\Livewire\Projects\Index as ProjectsIndex;
use App\Http\Livewire\Projects\Support as ProjectSupport;
use App\Http\Livewire\Tickets\Index as TicketsIndex;
use App\Http\Livewire\Tickets\Show as TicketShow;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('oauth/login', [LoginController::class, 'redirectToProvider'])
    ->middleware('guest')
    ->name('oauth.login');
Route::get('oauth/callback', [LoginController::class, 'handleProviderCallback'])->middleware('guest');

Route::get('password-protection', PasswordProtectionController::class)->name('password.protection');
Route::post('password-protection', [PasswordProtectionController::class, 'login'])->name('password.protection.login');

Route::group(['middleware' => 'authed'], function () {

    Route::get('docs/{docSlug}/builder', DocsBuilder::class)->name('docs.builder');

    Route::view('profile', 'auth.profile')->name('profile');
    Route::view('my', 'my')->name('my');

    Route::get('support', TicketsIndex::class)->name('support');
    Route::get('support/tickets/{uuid}', TicketShow::class)->name('support.ticket');

    Route::get('mention-search', MentionSearchController::class)->name('mention-search');
    Route::get('user/{username}', PublicUserController::class)->name('public-user');
});

Route::group(['prefix' => '/projects', 'as' => 'projects.'], function () {
    Route::get('/', ProjectsIndex::class)->name('index');
    Route::get('/{project}', fn ($project) => redirect()->route('projects.home', $project->slug));
    Route::get('/{project}/home', ProjectHome::class)->name('home');
    Route::get('/{project}/boards', ProjectBoards::class)->name('boards');
    Route::get('/{project}/boards/{board}', ProjectBoard::class)->name('boards.show');
    Route::get('/{project}/support', ProjectSupport::class)->name('support')->middleware(['middleware' => 'authed']);
    Route::get('/{project}/docs', ProjectDocs::class)->name('docs');
    Route::get('/{project}/faqs', ProjectFaqs::class)->name('faqs');
    Route::get('/{project}/changelog', ChangelogIndex::class)->name('changelog');
    Route::get('/{project}/changelog/{changelog}', ChangelogShow::class)->name('changelog.show');
    Route::post('/{project}/items/{item}/vote', [ItemController::class, 'vote'])->middleware('authed')->name('items.vote');
    Route::post('/{project}/items/{item}/update-board', [ItemController::class, 'updateBoard'])->middleware('authed')->name('items.update-board');
});

Route::group(['prefix' => '/docs', 'as' => 'docs.'], function () {
    Route::get('/', DocsIndex::class)->name('index');
    Route::get('/{docSlug}/{versionSlug?}/{chapterSlug?}/{pageSlug?}', DocumentationController::class)
        ->where('slug', '.*')
        ->name('show');
});

Route::get('items/{item}', ItemsShow::class)->name('items.show');
Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');

Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/unsubscribe/{item}/{user}', [ItemEmailUnsubscribeController::class, '__invoke'])
    ->name('items.email-unsubscribe')
    ->middleware('signed');

Route::view('/', 'welcome')->name('home');

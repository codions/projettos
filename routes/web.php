<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordProtectionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemEmailUnsubscribeController;
use App\Http\Controllers\MentionSearchController;
use App\Http\Controllers\PublicUserController;
use App\Http\Livewire\Changelog\Index as ChangelogIndex;
use App\Http\Livewire\Changelog\Show as ChangelogShow;
use App\Http\Livewire\Projects\Board as ProjectBoard;
use App\Http\Livewire\Projects\Boards as ProjectBoards;
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

Route::view('/', 'welcome')->name('home');

Route::get('changelog', ChangelogIndex::class)->name('changelog');
Route::get('changelog/{changelog}', ChangelogShow::class)->name('changelog.show');

Route::get('projects', ProjectsIndex::class)->name('projects.index');
Route::get('projects/{project}', fn ($project) => redirect()->route('projects.home', $project));
Route::get('projects/{project}/home', ProjectHome::class)->name('projects.home');
Route::get('projects/{project}/boards', ProjectBoards::class)->name('projects.boards');
Route::get('projects/{project}/boards/{board}', ProjectBoard::class)->name('projects.boards.show');
Route::get('projects/{project}/support', ProjectSupport::class)->name('projects.support');
Route::get('projects/{project}/docs', ProjectDocs::class)->name('projects.docs');
Route::get('projects/{project}/faqs', ProjectFaqs::class)->name('projects.faqs');

Route::get('items/{item}', [ItemController::class, 'show'])->name('items.show');
Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::get('projects/{project}/items/{item}', [ItemController::class, 'show'])->name('projects.items.show');
Route::post('projects/{project}/items/{item}/vote', [ItemController::class, 'vote'])->middleware('authed')->name('projects.items.vote');
Route::post('projects/{project}/items/{item}/update-board', [ItemController::class, 'updateBoard'])->middleware('authed')->name('projects.items.update-board');

Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::group(['middleware' => 'authed'], function () {

    Route::view('profile', 'auth.profile')->name('profile');
    Route::view('my', 'my')->name('my');

    Route::get('support', TicketsIndex::class)->name('support');
    Route::get('support/tickets/{uuid}', TicketShow::class)->name('support.ticket');

    Route::get('mention-search', MentionSearchController::class)->name('mention-search');
    Route::get('user/{username}', PublicUserController::class)->name('public-user');
});

Route::get('/unsubscribe/{item}/{user}', [ItemEmailUnsubscribeController::class, '__invoke'])
    ->name('items.email-unsubscribe')
    ->middleware('signed');

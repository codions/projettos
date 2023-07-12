<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Project;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function edit($id)
    {
        $item = auth()->user()->items()->findOrFail($id);

        return view('edit-item', [
            'item' => $item,
        ]);
    }

    public function vote(Request $request, $projectId, $itemId)
    {
        $project = Project::findOrFail($projectId);

        $item = $project->items()->visibleForCurrentUser()->findOrfail($itemId);

        $item->toggleUpvote();

        return redirect()->back();
    }

    public function updateBoard(Project $project, Item $item, Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->hasAdminAccess(), 403);

        $item->update($request->only('board_id'));

        Notification::make()
            ->title(trans('items.update-board-success', ['board' => $item->board->title]))
            ->success()
            ->send();

        return redirect()->back();
    }
}

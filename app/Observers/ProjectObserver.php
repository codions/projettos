<?php

namespace App\Observers;

use App\Enums\ProjectActivity;
use App\Models\Board;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectObserver
{
    public function created(Project $project)
    {
        ProjectActivity::createForProject($project, ProjectActivity::Created);
    }

    public function updating(Project $project)
    {
        if ($project->isDirty('group') && $project->group) {
            ProjectActivity::createForProject($project, ProjectActivity::ChangedTheGroup, [
                'group' => $project->group,
            ]);
        }

        if ($project->isDirty('title') && $project->title) {
            ProjectActivity::createForProject($project, ProjectActivity::ChangedTheTitle, [
                'title' => $project->title,
            ]);
        }

        if ($project->isDirty('description') && $project->description) {
            ProjectActivity::createForProject($project, ProjectActivity::ChangedTheDescription, [
                'description' => $project->description,
            ]);
        }

        if ($project->isDirty('pinned') && $project->pinned) {
            ProjectActivity::createForProject($project, ProjectActivity::Pinned);
        }

        if ($project->isDirty('pinned') && ! $project->pinned) {
            ProjectActivity::createForProject($project, ProjectActivity::Unpinned);
        }

        if ($project->isDirty('private') && $project->private) {
            ProjectActivity::createForProject($project, ProjectActivity::MadePrivate);
        }

        if ($project->isDirty('private') && ! $project->private) {
            ProjectActivity::createForProject($project, ProjectActivity::MadePublic);
        }
    }

    public function deleting(Project $project)
    {
        try {
            Storage::delete('public/og-' . $project->slug . '-' . $project->id . '.jpg');
        } catch (\Throwable $exception) {
        }

        $project->boards->each(fn (Board $board) => $board->delete());
    }
}

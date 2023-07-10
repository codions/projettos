<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function __invoke()
    {
        return view('projects.index');
    }

    public function show($id)
    {
        $project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $id)
            ->firstOrFail();

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}

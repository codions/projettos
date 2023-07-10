<?php

namespace App\Enums;

use App\Models\Project;
use Spatie\Activitylog\Models\Activity;

enum ProjectActivity: string
{
    case Created = 'created';

    case ChangedTheGroup = 'changed-the-group';
    case ChangedTheTitle = 'changed-the-title';
    case ChangedTheDescription = 'changed-the-description';
    case MadePrivate = 'made-private';
    case MadePublic = 'made-public';
    case Pinned = 'pinned';
    case Unpinned = 'unpinned';

    public static function createForProject(Project $project, ProjectActivity $projectActivity, array $attributes = []): void
    {
        activity()
            ->performedOn($project)
            ->withProperties(collect(['project-activity' => $projectActivity])->merge(['attributes' => $attributes]))
            ->log($projectActivity->getTranslation($attributes, 'en'));
    }

    public static function getForActivity(Activity $activity): ?self
    {
        $projectActivity = $activity->properties->get('project-activity');

        return self::tryFrom($projectActivity);
    }

    public function getTranslation(array $attributes = [], ?string $locale = null): string
    {
        return match ($this) {
            self::Created => trans('projects.activity.created', [], $locale),
            self::ChangedTheGroup => trans('projects.activity.changed-the-group', [], $locale),
            self::ChangedTheTitle => trans('projects.activity.changed-the-title', [], $locale),
            self::ChangedTheDescription => trans('projects.activity.changed-the-description', [], $locale),
            self::MadePrivate => trans('projects.activity.made-private', [], $locale),
            self::MadePublic => trans('projects.activity.made-public', [], $locale),
            self::Pinned => trans('projects.activity.pinned', [], $locale),
            self::Unpinned => trans('projects.activity.unpinned', [], $locale),
        };
    }
}

<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $tableRecordsPerPage = 16;

    public $search;

    public $sort = 'order';

    public $filter = [
        'type' => null,
    ];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'sort',
        'filter',
    ];

    public function render(): View
    {
        return view('livewire.projects.index')
            ->layoutData([
                'breadcrumbs' => [
                    ['title' => trans('projects.projects'), 'url' => route('projects.index')],
                ],
            ]);
    }

    public function showFilters(): bool
    {
        $total = Project::query()
            ->visibleForCurrentUser()
            ->count();

        return $total > $this->tableRecordsPerPage;
    }

    public function getProjects()
    {
        return Project::query()
            ->visibleForCurrentUser()
            ->when(
                ! empty($this->search),
                function (Builder $query): Builder {

                    $this->resetFilters(['sort', 'filter']);

                    return $query->where(function (Builder $query) {
                        return $query->where('title', 'like', "%{$this->search}%")
                            ->orWhere('description', 'like', "%{$this->search}%");
                    });
                },
            )
            ->when(
                ! empty($this->filter['private']),
                function (Builder $query): Builder {
                    return $query->where('private', $this->filter['private']);
                },
            )
            ->when(
                ! empty($this->filter['pinned']),
                function (Builder $query): Builder {
                    return $query->where('pinned', $this->filter['pinned']);
                },
            )
            ->when($this->sort === 'recent', fn (Builder $query): Builder => $query->latest())
            ->when($this->sort === 'order', fn (Builder $query): Builder => $query->orderBy('order'))
            ->when($this->sort === 'group', fn (Builder $query): Builder => $query->orderBy('group'))
            ->when($this->sort === 'alphabetical', fn (Builder $query): Builder => $query->orderBy('title'))
            ->paginate($this->tableRecordsPerPage);
    }

    public function resetFilters(array $keys = ['search', 'filter'])
    {
        $this->reset($keys);
        $this->resetPage();
    }
}

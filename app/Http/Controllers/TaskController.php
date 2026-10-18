<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller implements HasMiddleware
{
    private const PER_PAGE = 15;

    public static function middleware(): array
    {
        return [new Middleware('auth', except: ['index', 'show'])];
    }

    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            )
            ->with(['status', 'creator', 'assignee'])
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('tasks.index', [
            'tasks' => $tasks,
            'filter' => request()->input('filter', []),
            'statuses' => TaskStatus::orderBy('id')->pluck('name', 'id'),
            'users' => User::orderBy('id')->pluck('name', 'id'),
        ]);
    }

    public function show(Task $task)
    {
        $task->load(['status', 'labels']);

        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        Gate::authorize('create', Task::class);

        return view('tasks.create', ['task' => new Task(), ...$this->formOptions()]);
    }

    public function store(TaskRequest $request)
    {
        Gate::authorize('create', Task::class);
        $task = $request->user()->createdTasks()->create($request->validated());
        $task->labels()->sync($request->validated('labels', []));
        flash(__('tasks.created'))->success();

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', ['task' => $task, ...$this->formOptions()]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $task->update($request->validated());
        $task->labels()->sync($request->validated('labels', []));
        flash(__('tasks.updated'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();
        flash(__('tasks.deleted'))->success();

        return redirect()->route('tasks.index');
    }

    private function formOptions(): array
    {
        return [
            'statuses' => TaskStatus::orderBy('id')->pluck('name', 'id'),
            'users' => User::orderBy('id')->pluck('name', 'id'),
            'labels' => Label::orderBy('id')->pluck('name', 'id'),
        ];
    }
}

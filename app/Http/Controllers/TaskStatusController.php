<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth', except: ['index'])];
    }

    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->get();

        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        Gate::authorize('create', TaskStatus::class);

        return view('task_statuses.create', ['taskStatus' => new TaskStatus()]);
    }

    public function store(TaskStatusRequest $request)
    {
        Gate::authorize('create', TaskStatus::class);
        TaskStatus::create($request->validated());
        flash(__('task_statuses.created'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        Gate::authorize('update', $taskStatus);

        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        Gate::authorize('update', $taskStatus);
        $taskStatus->update($request->validated());
        flash(__('task_statuses.updated'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        Gate::authorize('delete', $taskStatus);

        if ($taskStatus->tasks()->exists()) {
            flash(__('task_statuses.delete_failed'))->error();
        } else {
            $taskStatus->delete();
            flash(__('task_statuses.deleted'))->success();
        }

        return redirect()->route('task_statuses.index');
    }
}

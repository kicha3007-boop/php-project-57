<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('tasks.index') }}</h1>

    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        {{ html()->form('GET', route('tasks.index'))->class('flex flex-wrap items-end gap-3')->open() }}
            {{ html()->select('filter[status_id]', $statuses, $filter['status_id'] ?? null)
                ->placeholder(__('tasks.status'))->class('rounded border-gray-300') }}
            {{ html()->select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null)
                ->placeholder(__('tasks.creator'))->class('rounded border-gray-300') }}
            {{ html()->select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? null)
                ->placeholder(__('tasks.assignee'))->class('rounded border-gray-300') }}
            <x-submit-button :label="__('tasks.apply')" />
        {{ html()->form()->close() }}

        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}"
               class="rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('tasks.create') }}</a>
        @endcan
    </div>

    <table class="w-full text-left">
        <thead class="border-b-2 border-gray-300">
            <tr>
                <th class="py-2">{{ __('layout.id') }}</th>
                <th class="py-2">{{ __('tasks.status') }}</th>
                <th class="py-2">{{ __('layout.name') }}</th>
                <th class="py-2">{{ __('tasks.creator') }}</th>
                <th class="py-2">{{ __('tasks.assignee') }}</th>
                <th class="py-2">{{ __('layout.created_at') }}</th>
                @auth
                    <th class="py-2">{{ __('layout.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="border-b border-gray-200">
                    <td class="py-2">{{ $task->id }}</td>
                    <td class="py-2">{{ $task->status->name }}</td>
                    <td class="py-2">
                        <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-800">{{ $task->name }}</a>
                    </td>
                    <td class="py-2">{{ $task->creator->name }}</td>
                    <td class="py-2">{{ $task->assignee?->name }}</td>
                    <td class="py-2">{{ $task->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td class="space-x-3 py-2">
                            @can('delete', $task)
                                <x-delete-link :url="route('tasks.destroy', $task)" />
                            @endcan
                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800">{{ __('layout.edit') }}</a>
                            @endcan
                        </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
</x-app-layout>

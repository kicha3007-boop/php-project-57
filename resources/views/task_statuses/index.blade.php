<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('task_statuses.index') }}</h1>

    @can('create', App\Models\TaskStatus::class)
        <a href="{{ route('task_statuses.create') }}"
           class="mb-6 inline-block rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('task_statuses.create') }}</a>
    @endcan

    <table class="w-full text-left">
        <thead class="border-b-2 border-gray-300">
            <tr>
                <th class="py-2">{{ __('layout.id') }}</th>
                <th class="py-2">{{ __('layout.name') }}</th>
                <th class="py-2">{{ __('layout.created_at') }}</th>
                @auth
                    <th class="py-2">{{ __('layout.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $taskStatus)
                <tr class="border-b border-gray-200">
                    <td class="py-2">{{ $taskStatus->id }}</td>
                    <td class="py-2">{{ $taskStatus->name }}</td>
                    <td class="py-2">{{ $taskStatus->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td class="space-x-3 py-2">
                            @can('delete', $taskStatus)
                                <x-delete-link :url="route('task_statuses.destroy', $taskStatus)" />
                            @endcan
                            @can('update', $taskStatus)
                                <a href="{{ route('task_statuses.edit', $taskStatus) }}" class="text-blue-600 hover:text-blue-800">{{ __('layout.edit') }}</a>
                            @endcan
                        </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>

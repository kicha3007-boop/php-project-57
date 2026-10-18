<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">
        {{ __('tasks.show', ['name' => $task->name]) }}
        @can('update', $task)
            <a href="{{ route('tasks.edit', $task) }}" class="ml-2 text-base font-normal text-blue-600 hover:text-blue-800">&#9881;</a>
        @endcan
    </h1>
    <dl class="space-y-2">
        <div><dt class="inline font-semibold">{{ __('layout.name') }}:</dt> <dd class="inline">{{ $task->name }}</dd></div>
        <div><dt class="inline font-semibold">{{ __('tasks.status') }}:</dt> <dd class="inline">{{ $task->status->name }}</dd></div>
        <div><dt class="inline font-semibold">{{ __('layout.description') }}:</dt> <dd class="inline">{{ $task->description }}</dd></div>
        <div>
            <dt class="inline font-semibold">{{ __('tasks.labels') }}:</dt>
            <dd class="inline">
                @foreach ($task->labels as $label)
                    <span class="mr-1 rounded bg-blue-100 px-2 py-0.5 text-sm text-blue-800">{{ $label->name }}</span>
                @endforeach
            </dd>
        </div>
    </dl>
</x-app-layout>

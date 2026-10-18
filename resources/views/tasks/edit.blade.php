<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('tasks.edit') }}</h1>
    {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->open() }}
        @include('tasks._form')
        <x-submit-button :label="__('layout.update')" />
    {{ html()->closeModelForm() }}
</x-app-layout>

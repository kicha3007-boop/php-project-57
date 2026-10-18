<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('task_statuses.edit') }}</h1>
    {{ html()->modelForm($taskStatus, 'PATCH', route('task_statuses.update', $taskStatus))->open() }}
        @include('task_statuses._form')
        <x-submit-button :label="__('layout.update')" />
    {{ html()->closeModelForm() }}
</x-app-layout>

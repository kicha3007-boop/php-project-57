<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('task_statuses.create') }}</h1>
    {{ html()->modelForm($taskStatus, 'POST', route('task_statuses.store'))->open() }}
        @include('task_statuses._form')
        <x-submit-button :label="__('layout.create')" />
    {{ html()->closeModelForm() }}
</x-app-layout>

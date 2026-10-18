<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('labels.create') }}</h1>
    {{ html()->modelForm($label, 'POST', route('labels.store'))->open() }}
        @include('labels._form')
        <x-submit-button :label="__('layout.create')" />
    {{ html()->closeModelForm() }}
</x-app-layout>

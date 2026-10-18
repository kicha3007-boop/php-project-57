<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('labels.edit') }}</h1>
    {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->open() }}
        @include('labels._form')
        <x-submit-button :label="__('layout.update')" />
    {{ html()->closeModelForm() }}
</x-app-layout>

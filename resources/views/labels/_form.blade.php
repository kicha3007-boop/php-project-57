<div class="mb-4 max-w-xl">
    {{ html()->label(__('layout.name'), 'name')->class('mb-1 block') }}
    {{ html()->text('name')->class('w-full rounded border-gray-300') }}
    <x-field-error name="name" />
</div>
<div class="mb-4 max-w-xl">
    {{ html()->label(__('layout.description'), 'description')->class('mb-1 block') }}
    {{ html()->textarea('description')->class('w-full rounded border-gray-300')->rows(5) }}
    <x-field-error name="description" />
</div>

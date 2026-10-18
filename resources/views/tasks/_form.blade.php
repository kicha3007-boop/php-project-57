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
<div class="mb-4 max-w-xl">
    {{ html()->label(__('tasks.status'), 'status_id')->class('mb-1 block') }}
    {{ html()->select('status_id', $statuses)->placeholder('----------')->class('w-full rounded border-gray-300') }}
    <x-field-error name="status_id" />
</div>
<div class="mb-4 max-w-xl">
    {{ html()->label(__('tasks.assignee'), 'assigned_to_id')->class('mb-1 block') }}
    {{ html()->select('assigned_to_id', $users)->placeholder('----------')->class('w-full rounded border-gray-300') }}
    <x-field-error name="assigned_to_id" />
</div>
<div class="mb-4 max-w-xl">
    {{ html()->label(__('tasks.labels'), 'labels')->class('mb-1 block') }}
    {{ html()->multiselect('labels', $labels, $task->labels->pluck('id'))->class('w-full rounded border-gray-300') }}
    <x-field-error name="labels" />
</div>

<x-app-layout>
    <h1 class="mb-6 text-4xl font-semibold">{{ __('labels.index') }}</h1>

    @can('create', App\Models\Label::class)
        <a href="{{ route('labels.create') }}"
           class="mb-6 inline-block rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('labels.create') }}</a>
    @endcan

    <table class="w-full text-left">
        <thead class="border-b-2 border-gray-300">
            <tr>
                <th class="py-2">{{ __('layout.id') }}</th>
                <th class="py-2">{{ __('layout.name') }}</th>
                <th class="py-2">{{ __('layout.description') }}</th>
                <th class="py-2">{{ __('layout.created_at') }}</th>
                @auth
                    <th class="py-2">{{ __('layout.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
                <tr class="border-b border-gray-200">
                    <td class="py-2">{{ $label->id }}</td>
                    <td class="py-2">{{ $label->name }}</td>
                    <td class="py-2">{{ $label->description }}</td>
                    <td class="py-2">{{ $label->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td class="space-x-3 py-2">
                            @can('delete', $label)
                                <x-delete-link :url="route('labels.destroy', $label)" />
                            @endcan
                            @can('update', $label)
                                <a href="{{ route('labels.edit', $label) }}" class="text-blue-600 hover:text-blue-800">{{ __('layout.edit') }}</a>
                            @endcan
                        </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>

@props(['url'])
<a href="{{ $url }}" data-confirm="{{ __('layout.confirm') }}" data-method="delete" rel="nofollow"
   class="text-red-600 hover:text-red-800">{{ __('layout.delete') }}</a>

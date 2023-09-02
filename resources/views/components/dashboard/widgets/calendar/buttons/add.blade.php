@props([
    'label' => null,
    'modal' => '#addEventPopup',
    'href' => '#',
])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-primary']) }} data-toggle="modal"
    data-target="{{ $modal }}">
    <em class="icon ni ni-plus"></em>
    <span>{{ CStr::isValidString($label) ? $label : 'Add event' }}</span>
</a>

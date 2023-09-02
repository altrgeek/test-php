<x-dashboard title="Create Cogni Progress Notes">
    <x-slot name="styles">
        <link rel="stylesheet" href="{{ asset("assets/css/editors/tinymce.css?ver=2.2.0") }}" />
    </x-slot>

    <form action="{{ route('dashboard.collective-support.save') }}" method="POST" class="pt-5">
        @csrf
        {{-- <textarea name="content" id="tinyEditor">{!! $content !!}</textarea> --}}
        <textarea class="tinymce-toolbar form-control">{!! $content !!}</textarea>
        <div class="d-flex justify-content-end pt-3">
            <a href="/" class="btn btn-secondary block mr-2">Cancel</a>
            <button class="btn btn-primary block">Save</button>
        </div>
    </form>

    <x-slot name="scripts">
        <script src="{{ asset("assets/js/libs/editors/tinymce.js?ver=2.2.0") }}"></script>
        <script src="{{ asset("assets/js/editors.js?ver=2.2.0") }}"></script>
        {{-- <script
        src="https://cdn.tiny.cloud/1/zm9vrkefhnehsvlyvifv8y5m272rktnp5njcph0wi4up61jl/tinymce/6/tinymce.min.js" referrerpolicy="origin"
        ></script> --}}
        {{-- <script>
            tinymce.init({
                selector: 'textarea#tinyEditor',
                plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
                toolbar_mode: 'floating',
            });
        </script> --}}
    </x-slot>
</x-dashboard>

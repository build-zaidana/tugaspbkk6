@if (session('status'))
    <x-adminlte-alert theme="success" dismissable>{{ session('status') }}</x-adminlte-alert>
@endif

@if ($errors->any())
    <x-adminlte-alert theme="danger" dismissable>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif

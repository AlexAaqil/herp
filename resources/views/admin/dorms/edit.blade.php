<x-authenticated-layout>
    <x-slot name="head">
        <title>Dorm | Update</title>
    </x-slot>

    <section class="Dorms">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('dorms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Dorm</p>
            </div>

            <form action="{{ route('dorms.update', $dorm->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name" class="required">Dorm Name</label>
                        <input type="text" name="name" id="name" placeholder="Neville House" value="{{ old('name', $dorm->name) }}">
                        <x-input-error field="name" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Dorm</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $dorm->id }}, 'dorm');"
                        form="deleteForm_{{ $dorm->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Dorm</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $dorm->id }}" action="{{ route('dorms.destroy', $dorm->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
    </x-slot>
</x-authenticated-layout>

<x-authenticated-layout>
    <x-slot name="head">
        <title>Subject | Update</title>
    </x-slot>

    <section class="Subject">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('subjects.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Subject</p>
            </div>

            <form action="{{ route('subjects.update', $subject->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name" class="required">Subject Name</label>
                        <input type="text" name="name" id="name" placeholder="Mathematics" value="{{ old('name', $subject->name) }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="acronym">Acronym</label>
                        <input type="text" name="acronym" id="acronym" placeholder="Eng" value="{{ old('acronym', $subject->acronym) }}">
                        <x-input-error field="acronym" />
                    </div>

                    <div class="inputs">
                        <label for="code">Subject Code</label>
                        <input type="text" name="code" id="code" placeholder="27537001" value="{{ old('code', $subject->code) }}">
                        <x-input-error field="code" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Subject</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $subject->id }}, 'subject');"
                        form="deleteForm_{{ $subject->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Subject</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $subject->id }}" action="{{ route('subjects.destroy', $subject->id) }}" method="post"
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

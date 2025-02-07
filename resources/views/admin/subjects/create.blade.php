<x-authenticated-layout>
    <x-slot name="head">
        <title>Subject | New</title>
    </x-slot>

    <section class="Subjects">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('subjects.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Subject</p>
            </div>

            <form action="{{ route('subjects.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name" class="required">Subject Name</label>
                        <input type="text" name="name" id="name" placeholder="Neville House" value="{{ old('name') }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="acronym">Acronym</label>
                        <input type="text" name="acronym" id="acronym" placeholder="Eng" value="{{ old('acronym') }}">
                        <x-input-error field="acronym" />
                    </div>

                    <div class="inputs">
                        <label for="code">Subject Code</label>
                        <input type="text" name="code" id="code" placeholder="27537001" value="{{ old('code') }}">
                        <x-input-error field="code" />
                    </div>
                </div>

                <button type="submit">Add Subject</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>

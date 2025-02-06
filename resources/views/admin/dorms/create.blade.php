<x-authenticated-layout>
    <x-slot name="head">
        <title>Dorm | New</title>
    </x-slot>

    <section class="Dorms">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('dorms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Dorm</p>
            </div>

            <form action="{{ route('dorms.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name" class="required">Dorm Name</label>
                        <input type="text" name="name" id="name" placeholder="Neville House" value="{{ old('name') }}">
                        <x-input-error field="name" />
                    </div>
                </div>

                <button type="submit">Add Dorm</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>

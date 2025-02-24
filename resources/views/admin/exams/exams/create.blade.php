<x-authenticated-layout>
    <x-slot name="head">
        <title>Exam | New</title>
    </x-slot>

    <section class="Exams">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('exams.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Exam</p>
            </div>

            <form action="{{ route('exams.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="name" value="{{ old('name') }}">
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <label for="year">Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year') }}" min="1995" max="2050">
                        <span class="inline_alert">{{ $errors->first('year') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="term">Term</label>
                        <select name="term" id="term">
                            <option value="">Select Term</option>
                            <option value="1" {{ old('term') == "1" ? "selected" : "" }}>Term 1</option>
                            <option value="2" {{ old('term') == "2" ? "selected" : "" }}>Term 2</option>
                            <option value="3" {{ old('term') == "3" ? "selected" : "" }}>Term 3</option>
                        </select>
                        <span class="inline_alert">{{ $errors->first('term') }}</span>
                    </div>
                </div>

                <button type="submit">Add Exam</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>

<x-authenticated-layout>
    <x-slot name="head">
        <title>Settings | Update</title>
    </x-slot>

    <section class="Settings">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('settings.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Settings</p>
            </div>

            <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="input_group">
                    <div class="inputs">
                        <label for="school_name" class="required">School Name</label>
                        <input type="text" name="school_name" value="{{ old('school_name', $settings->school_name ?? '') }}" required>
                        <x-input-error field="school_name" />
                    </div>

                    <div class="inputs">
                        <label for="school_acronym" class="required">School Acronym</label>
                        <input type="text" name="school_acronym" value="{{ old('school_acronym', $settings->school_acronym ?? '') }}" required>
                        <x-input-error field="school_acronym" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="school_address" class="required">Address</label>
                        <input type="text" name="school_address" value="{{ old('school_address', $settings->school_address ?? '') }}" required>
                        <x-input-error field="school_address" />
                    </div>

                    <div class="inputs">
                        <label for="school_email" class="required">Email</label>
                        <input type="email" name="school_email" value="{{ old('school_email', $settings->school_email ?? '') }}" required>
                        <x-input-error field="school_email" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="school_phone_number" class="required">Phone Number</label>
                        <input type="text" name="school_phone_number" value="{{ old('school_phone_number', $settings->school_phone_number ?? '') }}" required>
                        <x-input-error field="school_phone_number" />
                    </div>

                    <div class="inputs">
                        <label>Other Phone</label>
                        <input type="text" name="school_phone_other" value="{{ old('school_phone_other', $settings->school_phone_other ?? '') }}">
                        <x-input-error field="school_phone_other" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label>Current Year</label>
                        <input type="number" name="current_year" value="{{ old('current_year', $settings->current_year ?? '') }}">
                        <x-input-error field="current_year" />
                    </div>

                    <div class="inputs">
                        <label>Current Term</label>
                        <select name="current_term">
                            <option value="">Select Term</option>
                            <option value="1" {{ old('current_term', $settings->current_term ?? '') == 1 ? 'selected' : '' }}>Term 1</option>
                            <option value="2" {{ old('current_term', $settings->current_term ?? '') == 2 ? 'selected' : '' }}>Term 2</option>
                            <option value="3" {{ old('current_term', $settings->current_term ?? '') == 3 ? 'selected' : '' }}>Term 3</option>
                        </select>
                        <x-input-error field="current_year" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label>Term Begins</label>
                        <input type="date" name="term_begins" value="{{ old('term_begins', $settings->term_begins ?? '') }}">
                        <x-input-error field="term_begins" />
                    </div>

                    <div class="inputs">
                        <label>Term Ends</label>
                        <input type="date" name="term_ends" value="{{ old('term_ends', $settings->term_ends ?? '') }}">
                        <x-input-error field="term_ends" />
                    </div>
               </div>

               @php
                    $defaultImage = asset('assets/images/default_image.jpg');
                @endphp

                <div class="input_group_3">
                    <div class="image">
                        <label>Principal's Stamp</label>
                        <img id="preview_principal_stamp"
                            src="{{ $settings?->principal_stamp ?: $defaultImage }}" 
                            alt="Principal's Stamp" width="150" height="150" 
                            onclick="document.getElementById('principal_stamp').click();">
                        <input type="file" name="principal_stamp" id="principal_stamp" accept="image/*" style="display: none;">
                    </div>

                    <div class="image">
                        <label>Bursar's Stamp</label>
                        <img id="preview_bursar_stamp"
                            src="{{ $settings?->bursar_stamp ?: $defaultImage }}" 
                            alt="Bursar's Stamp" width="150" height="150" 
                            onclick="document.getElementById('bursar_stamp').click();">
                        <input type="file" name="bursar_stamp" id="bursar_stamp" accept="image/*" style="display: none;">
                    </div>

                    <div class="image">
                        <label>Storekeeper's Stamp</label>
                        <img id="preview_storekeeper_stamp"
                            src="{{ $settings?->storekeeper_stamp ?: $defaultImage }}" 
                            alt="Storekeeper's Stamp" width="150" height="150" 
                            onclick="document.getElementById('storekeeper_stamp').click();">
                        <input type="file" name="storekeeper_stamp" id="storekeeper_stamp" accept="image/*" style="display: none;">
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Settings</button>
                </div>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function(event) {
                    let file = event.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let previewId = 'preview_' + event.target.id;
                            document.getElementById(previewId).src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    </x-slot>
</x-authenticated-layout>

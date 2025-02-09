<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Student | New</title>
    </x-slot>

    <section class="Users">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('students.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New Student</p>
            </div>

            <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
                        <x-input-error field="first_name" />
                    </div>

                    <div class="inputs">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
                        <x-input-error field="last_name" />
                    </div>

                    <div class="inputs">
                        <label for="gender" class="required">Gender</label>
                        <div class="custom_radio_buttons">
                            <label>
                                <input class="option_radio" type="radio" name="gender" id="M" value="M"
                                    {{ old('gender', 'M') == 'M' ? 'checked' : '' }}>
                                <span>Male</span>
                            </label>
    
                            <label>
                                <input class="option_radio" type="radio" name="gender" id="F" value="F"
                                    {{ old('gender') == 'F' ? 'checked' : '' }}>
                                <span>Female</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="adm_no">Admission Number</label>
                        <input type="text" name="adm_no" id="adm_no" value="{{ old('adm_no') }}">
                        <x-input-error field="adm_no" />
                    </div>

                    <div class="inputs">
                        <label for="year_admitted">Year Admitted</label>
                        <input type="date" name="year_admitted" id="year_admitted" value="{{ old('year_admitted') }}">
                        <x-input-error field="year_admitted" />
                    </div>

                    <div class="inputs">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}">
                        <x-input-error field="dob" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="classroom_id" class="required">Classroom</label>
                        <select name="classroom_id" id="classroom_id">
                            <option value="">Select Classroom</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}"
                                    {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="classroom_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="dorm_id">Dorm</label>
                        <select name="dorm_id" id="dorm_id">
                            <option value="">Select Dorm</option>
                            @foreach ($dorms as $dorm)
                                <option value="{{ $dorm->id }}" {{ old('dorm_id') == $dorm->id ? 'selected' : '' }}>{{ $dorm->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="dorm_id" />
                    </div>
    
                    <div class="inputs">
                        <label for="dorm_room">Dorm Room Number</label>
                        <input type="text" name="dorm_room" id="dorm_room" value="{{ old('dorm_room') }}">
                        <x-input-error field="dorm_room" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                        <x-input-error field="image" />
                    </div>

                    <div class="inputs">
                        <label for="password">Password</label>
                        <input type="text" name="password" id="password" placeholder="Leave as black for default st123456">
                        <x-input-error field="password" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="guardian_ids">Select Guardian(s)</label>
                        <select name="guardian_ids[]" id="guardian_ids" class="searchable_select" multiple>
                            <option value="">Search for a parent</option>
                            @foreach ($guardians as $guardian)
                                <option value="{{ $guardian->id }}"
                                    {{ in_array($guardian->id, old('guardian_ids', [])) ? 'selected' : '' }}>
                                    {{ $guardian->phone_number }} - {{ $guardian->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error field="guardian_ids" />
                    </div>
                </div>

                <button type="submit">Add Student</button>
            </form>
        </div>

        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('students.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>

                <p>New Guardian</p>
            </div>

            <form action="{{ route('guardians.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="guardian_first_name" class="required">First Name</label>
                        <input type="text" name="guardian_first_name" id="guardian_first_name" value="{{ old('guardian_first_name') }}">
                        <x-input-error field="guardian_first_name" />
                    </div>

                    <div class="inputs">
                        <label for="guardian_last_name" class="required">Last Name</label>
                        <input type="text" name="guardian_last_name" id="guardian_last_name" value="{{ old('guardian_last_name') }}">
                        <x-input-error field="guardian_last_name" />
                    </div>

                    <div class="inputs">
                        <label for="email" class="required">Email Address</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}">
                        <x-input-error field="email" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="phone_number" class="required">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" placeholder="07xxxxxxxxxx or 01xxxxxxxxxx" value="{{ old('phone_number') }}">
                        <x-input-error field="phone_number" />
                    </div>

                    <div class="inputs">
                        <label for="phone_other">Other Phone Number</label>
                        <input type="text" name="phone_other" id="phone_other" value="{{ old('phone_other') }}">
                        <x-input-error field="phone_other" />
                    </div>

                    <div class="inputs">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" placeholder="Vamplaza, Kiambu Town, Kiambu" value="{{ old('address') }}">
                        <x-input-error field="address" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="guardian_image">Image</label>
                        <input type="file" name="guardian_image" id="guardian_image">
                        <x-input-error field="guardian_image" />
                    </div>
                </div>

                <button type="submit">Add Guardian</button>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-searchable-select-js />
    </x-slot>
</x-authenticated-layout>

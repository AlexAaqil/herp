<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Student | Update</title>
    </x-slot>

    <section class="Users">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('students.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Student Details</p>
            </div>

            <div class="details">
                <div class="columns">
                    <div class="column">
                        <p class="title">Student</p>
                        <div class="contents">
                            <div class="image">
                                <img src="{{ $student->image_path }}" alt="Student profile photo" width="100" height="100">
                            </div>
    
                            <p>
                                <span>Name:</span>
                                <span>{{ $student->first_name . ' ' . $student->last_name }}</span>
                            </p>
                            <p>
                                <span>Adm No:</span>
                                <span>{{ $student->adm_no ?? '-' }}</span>
                            </p>
                            <p>
                                <span>Gender:</span>
                                <span>{{ $student->gender }}</span>
                            </p>
                            <p>
                                <span>Class:</span>
                                <span>{{ $student->classroom->name }}</span>
                            </p>
                            <p>
                                <span>Dorm:</span>
                                <span>{{ $student->dorm->name ?? '-' }}</span>
                            </p>
                            <p>
                                <span>Admission Year:</span>
                                <span>{{ $student->year_admitted ?? '-' }}</span>
                            </p>
                            <p>
                                <span>D.O.B:</span>
                                <span>{{ $student->dob ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="column">
                        <p class="title">Guardians</p>
                        @forelse ($student->guardians as $guardian)
                            <div class="contents">
                                <p class="title">{{ $guardian->full_name }}</p>
                                <p>{{ $guardian->phone_numbers }}</p>
                                <p>{{ $guardian->email }}</p>
                            </div>
                        @empty
                            <p>No guardians have been selected.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @can('view-as-admin')
            <div class="custom_form">
                <div class="header">
                    <div class="icon">
                        <a href="{{ route('students.index') }}">
                            <span class="fas fa-arrow-left"></span>
                        </a>
                    </div>
                    <p>Update Student</p>
                </div>

                <form action="{{ route('students.update', $student->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <div class="input_group_3">
                        <div class="inputs">
                            <label for="first_name" class="required">First Name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}">
                            <x-input-error field="first_name" />
                        </div>

                        <div class="inputs">
                            <label for="last_name" class="required">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}">
                            <x-input-error field="last_name" />
                        </div>

                        <div class="inputs">
                            <label for="adm_no">Admission Number</label>
                            <input type="text" name="adm_no" id="adm_no" value="{{ old('adm_no', $student->adm_no) }}">
                            <x-input-error field="adm_no" />
                        </div>
                    </div>

                    <div class="input_group_3">
                        <div class="inputs">
                            <label for="gender" class="required">Gender</label>
                            <div class="custom_radio_buttons">
                                <label>
                                    <input class="option_radio" type="radio" name="gender" id="M" value="M"
                                        {{ old('gender', $student->gender) == 'M' ? 'checked' : '' }}>
                                    <span>Male</span>
                                </label>
        
                                <label>
                                    <input class="option_radio" type="radio" name="gender" id="F" value="F"
                                        {{ old('gender', $student->gender) == 'F' ? 'checked' : '' }}>
                                    <span>Female</span>
                                </label>
                            </div>
                        </div>

                        <div class="inputs">
                            <label for="year_admitted">Year Admitted</label>
                            <input type="date" name="year_admitted" id="year_admitted" value="{{ old('year_admitted') }}">
                            <x-input-error field="year_admitted" />
                        </div>

                        <div class="inputs">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="{{ old('dob', $student->dob) }}">
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
                                        {{ old('classroom_id', $student->classroom_id) == $classroom->id ? 'selected' : '' }}>
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
                                    <option value="{{ $dorm->id }}" {{ old('dorm_id', $student->dorm_id) == $dorm->id ? 'selected' : '' }}>{{ $dorm->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error field="dorm_id" />
                        </div>
        
                        <div class="inputs">
                            <label for="dorm_room">Dorm Room Number</label>
                            <input type="text" name="dorm_room" id="dorm_room" value="{{ old('dorm_room', $student->dorm_room) }}">
                            <x-input-error field="dorm_room" />
                        </div>
                    </div>

                    <div class="input_group_3">
                        <div class="inputs">
                            <label for="graduation_status">Graduation Status?</label>
                            <div class="custom_radio_buttons">
                                <label>
                                    <input class="option_radio" type="radio" name="graduation_status" id="no"
                                        value="0"
                                        {{ old('graduation_status', $student->graduation_status) == '0' ? 'checked' : '' }}>
                                    <span>Enrolled</span>
                                </label>

                                <label>
                                    <input class="option_radio" type="radio" name="graduation_status" id="yes"
                                        value="1"
                                        {{ old('graduation_status', $student->graduation_status) == '1' ? 'checked' : '' }}>
                                    <span>Graduated</span>
                                </label>
                            </div>
                        </div>

                        <div class="inputs">
                            <label for="graduation_date">Graudation Date</label>
                            <input type="date" id="graduation_date" name="graduation_date"
                                value="{{ old('graduation_date', $student->graduation_date) }}">
                            <span class="inline_alert">{{ $errors->first('graduation_date') }}</span>
                        </div>

                        <div class="inputs">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" placeholder="Leave as black for default st123456">
                            <x-input-error field="password" />
                        </div>
                    </div>

                    <div class="input_group">
                        <div class="inputs">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image">
                            <span class="inline_alert">{{ $errors->first('image') }}</span>
                        </div>

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

                    <div class="buttons">
                        <button type="submit">Update Student</button>

                        <button type="button" class="btn_danger" onclick="deleteItem({{ $student->id }}, 'student');"
                            form="deleteForm_{{ $student->id }}">
                            <i class="fas fa-trash-alt delete"></i>
                            <span>Delete Student</span>
                        </button>
                    </div>
                </form>

                <form id="deleteForm_{{ $student->id }}" action="{{ route('students.destroy', $student->id) }}" method="post"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endcan
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
        <x-searchable-select-js />
    </x-slot>
</x-authenticated-layout>

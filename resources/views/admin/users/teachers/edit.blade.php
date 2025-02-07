<x-authenticated-layout>
    <x-slot name="head">
        <title>Teacher | Edit</title>
    </x-slot>

    <section class="Users">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('teachers.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>

                <p>Update Teacher Details</p>
            </div>

            <div class="details">
                <div class="columns">
                    <div class="column">
                        <div class="image">
                            @if($teacher->image)
                                <img id="previewImage" src="{{ asset('storage/' . $teacher->image) }}" alt="User" width="100" height="100">
                            @else
                                <x-default-profile-image />
                            @endif
                        </div>
                        <p class="title">{{ $teacher->full_name }}</p>
                        <p>{{ $teacher->email }}</p>
                        <p>{{ $teacher->phone_numbers }}</p>
                    </div>

                    <div class="column">
                        <form action="{{ route('users.update', ['user', $teacher->id]) }}" method="post">
                            @csrf
                            @method('patch')
            
                            <div class="inputs">
                                <label for="user_status">User Status</label>
                                <div class="custom_radio_buttons">
                                    @foreach(App\Models\User::USERSTATUS as $key => $label)
                                        <label>
                                            <input class="option_radio" 
                                                type="radio" 
                                                name="user_status" 
                                                value="{{ $key }}"
                                                {{ old('user_status', $teacher->user_status) == $key ? 'checked' : '' }}>
                                            <span>{{ ucfirst($label) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error field="user_status" />
                            </div>

                            <div class="input_group">
                                <div class="inputs">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" id="password" placeholder="Password">
                                    <x-input-error field="password" />
                                </div>
                
                                <div class="inputs">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                    <x-input-error field="password confirmation" />
                                </div>
                            </div>
            
                            @can('update-user', $teacher)
                                <div class="buttons">
                                    <button type="submit">Update User</button>
                                    
                                    <button type="button" class="btn_danger" onclick="deleteItem({{ $teacher->id }}, 'teacher');"
                                        form="deleteForm_{{ $teacher->id }}">
                                        <i class="fas fa-trash-alt delete"></i>
                                        <span>Delete User</span>
                                    </button>
                                </div>
                            @endcan
                        </form>
            
                        <form id="deleteForm_{{ $teacher->id }}" action="{{ route('users.destroy', $teacher->id) }}" method="post"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('teachers.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>

                <p>Assign Class Subjects</p>
            </div>

            <div class="details">
                <div class="columns">
                    <div class="column">
                        @forelse ($teacher->classroomSubjects as $assignment)
                            <p>
                                <a href="{{ route('teacher-subjects.edit', $assignment->id) }}">{{ $assignment->classroom->name . ' - ' . $assignment->subject->name }}</a>
                            </p>
                        @empty
                            <p>No class subjects have been assigned.</p>
                        @endforelse
                    </div>

                    <div class="column">
                        <form action="{{ route('teacher-subjects.store') }}" method="post">
                            @csrf
            
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            
                            <div class="input_group">
                                <div class="inputs">
                                    <label for="classroom_id">Class</label>
                                    <select name="classroom_id" id="classroom_id">
                                        <option value="">Select Class</option>
                                        @foreach ($classrooms as $classroom)
                                            <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error field="classroom_id" />
                                </div>
            
                                <div class="inputs">
                                    <label for="subject_id">Subject</label>
                                    <select name="subject_id" id="subject_id">
                                        <option value="">Select Subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error field="subject_id" />
                                </div>
                            </div>
            
                            <button type="submit">Assign Class Subject</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
    </x-slot>
</x-authenticated-layout>
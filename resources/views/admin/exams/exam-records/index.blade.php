<x-authenticated-layout>
    <x-slot name="head">
        <title>Exam Records</title>
    </x-slot>

    <section class="Exams">
        <div class="system_nav">
            <a href="{{ route('exams.index') }}">Exams</a>
            <span>Exam Records</span>
        </div>

        <div class="body">
            <div class="custom_form">
                <form action="{{ route('exam-records.index') }}" method="get">                    
                    <div class="input_group_3">
                        <div class="inputs">
                            <label for="exam_id">Exam:</label>
                            <select name="exam_id" id="exam_id" required>
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id', $exam_id) == $exam->id ? "selected" : "" }}>
                                        {{ $exam->name }} ({{ $exam->year }} Term {{ $exam->term }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error field="exam_id" />
                        </div>

                        <div class="inputs">
                            <label for="classroom">Classroom:</label>
                            <select name="classroom_id" id="classroom_id" required>
                                <option value="">Select Classroom</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ old('classroom_id', $classroom_id) == $classroom->id ? "selected" : "" }}>{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error field="classroom_id" />
                        </div>
                    
                        <div class="inputs">
                            <label for="subject_id">Subject:</label>
                            <select name="subject_id" id="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $subject_id) == $subject->id ? "selected" : "" }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error field="subject_id" />
                        </div>
                    </div>
                
                    <button type="submit">Start Entering Marks</button>
                </form>
            </div>

            @if($students_with_marks->isNotEmpty() || $students_without_marks->isNotEmpty())
                <form action="{{ route('exam-records.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="exam_id" value="{{ $exam_id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject_id }}">
                    <input type="hidden" name="classroom_id" value="{{ $classroom_id }}">
                
                    <p>Marks for Form <b>{{ $selected_classroom ? $selected_classroom->name : '' }} {{ $selected_subject ? $selected_subject->name : '' }} - {{ $selected_exam ? $selected_exam->name : '' }} ({{ $selected_exam ? $selected_exam->year : '' }} Term {{ $selected_exam ? $selected_exam->term : '' }})</b></p>
                
                    @if($students_with_marks->isNotEmpty())
                        <p class="title">Students with marks</p>
                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Marks (0-100)</th>
                                        <th class="center">Exclude</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students_with_marks as $student)
                                        <tr>
                                            <td>
                                                <p>{{ $student->full_name }}</p>
                                                <p>{{ $student->adm_no }}</p>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="marks[{{ $student->id }}]"
                                                       min="0" 
                                                       max="100" 
                                                       value="{{ $existing_records[$student->id]->marks }}">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="exclude[{{ $student->id }}]" value="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <p class="title">Students without marks</p>
                    @if($students_without_marks->isNotEmpty())
                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Marks (0-100)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students_without_marks as $student)
                                        <tr>
                                            <td>
                                                <p>{{ $student->full_name }}</p>
                                                <p>{{ $student->adm_no }}</p>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="marks[{{ $student->id }}]"
                                                       min="0" 
                                                       max="100">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                
                    <button type="submit">Save All Marks</button>
                </form>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>
<x-authenticated-layout>
    <x-slot name="head">
        <title>Exam Records | Marks Entry</title>
    </x-slot>

    <section class="Exams">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('exam-records.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Marks Entry</p>
            </div>

            <form action="{{ route('exam-records.store') }}" method="POST">
                @csrf

                <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
            
                <p class="title">Form {{ $classroom->name }}</p>
                <p class="title">Enter Marks for {{ $subject->name }} - {{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }}</p>
            
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Marks (0-100)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->full_name }}</td>
                                    <td>
                                        <input type="number" 
                                               name="marks[{{ $student->id }}]"
                                               min="0" 
                                               max="100" 
                                               required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <button type="submit">Save All Marks</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>

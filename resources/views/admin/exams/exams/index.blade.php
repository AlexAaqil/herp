<x-authenticated-layout>
    <x-slot name="head">
        <title>Exams</title>
    </x-slot>

    <section class="Exams">
        <div class="system_nav">
            <a href="{{ route('exam-records.index') }}">Exam Records</a>
            <span>Exams</span>
        </div>

        <div class="body">
            @if ($exams->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Exams</p>
                            <p class="stats">
                                <span>{{ $count_exams }} {{ Str::plural('Exam', $count_exams) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('exams.create') }}">New Exam</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Exam</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $exam->name }} {{ $exam->year }} Term {{ $exam->term }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('exams.edit', $exam->id) }}">
                                                    <span class="fas fa-eye"></span> 
                                                </a> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No exams yet.</p>
                <a href="{{ route('exams.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

<x-authenticated-layout>
    <x-slot name="head">
        <title>Grades</title>
    </x-slot>

    <section class="Grades">
        <div class="body">
            @if ($grades->isNotEmpty())
                <div class="table">
                    <div class="header">
                        <div class="details">
                            <p class="title">Grades</p>
                            <p class="stats">
                                <span>{{ $count_grades }} {{ Str::plural('Grade', $count_grades) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('grades.create') }}">New Grade</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Marks</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($grades as $grade)
                                <tr class="searchable">
                                    <td>{{ $grade->grade }}</td>
                                    <td>{{ $grade->min_marks . ' - ' . $grade->max_marks }}</td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('grades.edit', $grade->id) }}">
                                                <span class="fas fa-eye"></span> 
                                            </a> 
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No grades yet.</p>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

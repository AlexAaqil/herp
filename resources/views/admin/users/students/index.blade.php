<x-authenticated-layout>
    <x-slot name="head">
        <title>Students</title>
    </x-slot>

    <section class="Users">
        <div class="body">
            @if ($students->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Students</p>
                            <p class="stats">
                                <span>{{ $count_students }} {{ Str::plural('Student', $count_students) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('students.create') }}">New Student</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Image</th>
                                <th>Student</th>
                                <th>Classroom</th>
                                <th>Guardians</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $student->image_path }}" alt="Student profile photo" width="30px" height="30px">
                                    </td>
                                    <td>
                                        <p>{{ $student->full_name }}</p>
                                        <p>{{ $student->adm_no ?? '-' }}</p>
                                    </td>
                                    <td>{{ $student->classroom->name }}</td>
                                    <td>
                                        @forelse ($student->guardians as $guardian)
                                            <p>{{ $guardian->full_name }}</p>
                                        @empty
                                            <p>-</p>
                                        @endforelse
                                    </td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('students.edit', $student->id) }}">
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
                <p>No students yet.</p>
                <a href="{{ route('students.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>
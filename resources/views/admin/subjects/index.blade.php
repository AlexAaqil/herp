<x-authenticated-layout>
    <x-slot name="head">
        <title>Subjects</title>
    </x-slot>

    <section class="Subjects">
        <div class="body">
            @if ($subjects->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Subjects</p>
                            <p class="stats">
                                <span>{{ $count_subjects }} {{ Str::plural('Subject', $count_subjects) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('subjects.create') }}">New Subject</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Subject</th>
                                <th>Acronym</th>
                                <th>Code</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->acronym ?? '-' }}</td>
                                    <td>{{ $subject->code ?? '-' }}</td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('subjects.edit', $subject->id) }}">
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
                <p>No subjects yet.</p>
                <a href="{{ route('subjects.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

<x-authenticated-layout>
    <x-slot name="head">
        <title>Assignments</title>
    </x-slot>

    <section class="Assignments">
        <div class="body">
            @if ($assignments->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Assignments</p>
                            <p class="stats">
                                <span>{{ $count_assignments }} {{ Str::plural('Assignment', $count_assignments) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('assignments.create') }}">New Assignment</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                @can('view-as-admin')
                                    <th>Uploaded by</th>
                                @endcan
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Date Issued</th>
                                <th>Deadline</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    @can('view-as-admin')
                                        <td>{{ $assignment->teacher->full_name }}</td>
                                    @endcan
                                    <td>{{ $assignment->classroom->name }}</td>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($assignment->date_issued)->format('j') }}<sup>{{ \Carbon\Carbon::parse($assignment->date_issued)->format('S') }}</sup> {{ \Carbon\Carbon::parse($assignment->date_issued)->format('M Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($assignment->deadline)->format('j') }}<sup>{{ \Carbon\Carbon::parse($assignment->deadline)->format('S') }}</sup> {{ \Carbon\Carbon::parse($assignment->deadline)->format('M Y') }}
                                    </td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('assignments.edit', $assignment->id) }}">
                                                    <span class="fas fa-eye"></span> 
                                                </a> 
                                            </div>

                                            <div class="action">
                                                <a href="{{ route('assignments.download', $assignment->id) }}">
                                                    <span class="fas fa-download"></span> 
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
                <p>No assignments yet.</p>
                <a href="{{ route('assignments.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

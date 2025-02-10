<x-authenticated-layout>
    <x-slot name="head">
        <title>Leaveouts</title>
    </x-slot>

    <section class="Leaves">
        <div class="body">
            @if ($leaveouts->isNotEmpty())
                <div class="table">
                    <div class="header">
                        <div class="details">
                            <p class="title">Leaveouts</p>
                            <p class="stats">
                                <span>{{ $count_leaveouts }} {{ Str::plural('Leaveout', $count_leaveouts) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('leaveouts.create') }}">New Leaveout</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Student</th>
                                <th>Category</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Approved by</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($leaveouts as $leaveout)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>
                                        <p>{{ $leaveout->student->full_name }}</p>
                                        <p>{{ $leaveout->student->adm_no }}</p>
                                    </td>
                                    <td>{{ $leaveout->category }}</td>
                                    <td>{!! Illuminate\Support\Str::limit($leaveout->comment, 50, ' ...') !!}</td>
                                    <td>{{ $leaveout->from_date . ' to ' . $leaveout->to_date  }}</td>
                                    <td>{{ $leaveout->createdBy->full_name }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('leaveouts.edit', $leaveout->id) }}">
                                                    <span class="fas fa-eye"></span> 
                                                </a> 
                                            </div>
    
                                            <div class="action">
                                                <a href="{{ route('leaveouts.edit', $leaveout->id) }}">
                                                    <span class="fas fa-print"></span> 
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
                <p>No leaveouts yet.</p>
                <a href="{{ route('leaveouts.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

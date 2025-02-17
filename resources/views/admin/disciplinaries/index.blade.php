<x-authenticated-layout>
    <x-slot name="head">
        <title>Disciplinaries</title>
    </x-slot>

    <section class="Disciplinaries">
        <div class="body">
            @if ($disciplinaries->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Disciplinaries</p>
                            <p class="stats">
                                <span>{{ $count_disciplinaries }} {{ Str::plural('Disciplinary', $count_disciplinaries) }}</span>
                                <span>{{ $count_major }} Major</span>
                                <span>{{ $count_minor }} Minor</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('disciplinaries.create') }}">New Disciplinary</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Image</th>
                                <th>Student</th>
                                <th>Category</th>
                                <th>Comment</th>
                                <th>Created by</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($disciplinaries as $disciplinary)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $disciplinary->student->image_path }}" alt="Student Profile Photo">
                                    </td>
                                    <td>
                                        <p>{{ $disciplinary->student->full_name }}</p>
                                        <p>{{ $disciplinary->student->adm_no }}</p>
                                    </td>
                                    <td>{{ $disciplinary->category }}</td>
                                    <td>{!! Illuminate\Support\Str::limit($disciplinary->comment, 50, ' ...') !!}</td>
                                    <td>{{ $disciplinary->createdBy->full_name }}</td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('disciplinaries.edit', $disciplinary->id) }}">
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
                <p>No disciplinaries yet.</p>
                <a href="{{ route('disciplinaries.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

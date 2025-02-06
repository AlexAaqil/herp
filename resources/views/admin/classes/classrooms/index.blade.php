<x-authenticated-layout>
    <x-slot name="head">
        <title>Classrooms</title>
    </x-slot>

    <section class="Classrooms">
        <div class="body">
            @if ($grouped_classrooms->isNotEmpty())
                <div class="table">
                    <div class="header">
                        <div class="details">
                            <p class="title">Classrooms</p>
                            <p class="stats">
                                <span>{{ $count_classroom_categories }} {{ Str::plural('Category', $count_classroom_categories) }}</span>
                                <span>{{ $count_classrooms }} {{ Str::plural('Classroom', $count_classrooms) }}</span>
                            </p>
                        </div>

                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('classrooms.create') }}">New Classroom</a>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Categories</th>
                                <th>Classrooms</th>
                                <th>Class Teachers</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($grouped_classrooms as $categoryId => $classrooms)
                                @php
                                    $category = App\Models\Classrooms\ClassroomCategory::find($categoryId);
                                @endphp
                                <tr class="searchable">
                                    <td>
                                        <a href="{{ route('classroom-categories.edit', $category->id) }}">
                                            {{ $category->name }}
                                        </a>
                                    </td>

                                    <td>
                                        @forelse ($classrooms as $classroom)
                                            <p>{{ $classroom->name }}</p>
                                        @empty
                                            <p>No classrooms</p>
                                        @endforelse
                                    </td>

                                    <td>
                                        @forelse ($classrooms as $classroom)
                                            <p>
                                                {{ $classroom->classTeacher->full_name ?? 'No teacher assigned' }}
                                            </p>
                                        @empty
                                            <p>No classrooms</p>
                                        @endforelse
                                    </td>

                                    <td class="actions center">
                                        @forelse ($classrooms as $classroom)
                                            <div class="action">
                                                <a href="{{ route('classrooms.edit', $classroom->id) }}">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            </div>
                                        @empty
                                            <p>No classrooms</p>
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No classrooms yet.</p>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

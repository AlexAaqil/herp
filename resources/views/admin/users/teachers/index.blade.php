<x-authenticated-layout>
    <x-slot name="head">
        <title>Teachers</title>
    </x-slot>

    <section class="Users">
        <div class="body">
            @if ($teachers->isNotEmpty())
                <div class="table">
                    <div class="header">
                        <div class="details">
                            <p class="title">Teachers</p>
                            <p class="stats">
                                <span>{{ $count_teachers }} {{ Str::plural('Teacher', $count_teachers) }}</span>
                                <span>{{ $count_inactive_teachers }} Inactive</span>
                            </p>
                        </div>
    
                        <x-search-input />
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr class="searchable {{ $teacher->user_status == 0 ? 'inactive' : '' }}">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($teacher->user_level_label === 'admin' || $teacher->user_level_label === 'super admin')
                                            {{ $teacher->full_name }}
                                            <span class="badge {{ $teacher->user_level_label === 'admin' ? 'admin' : 'super_admin' }}">
                                                {{ $teacher->user_level_label }}
                                            </span>
                                        @else
                                            {{ $teacher->full_name }}
                                        @endif
                                    </td>
                                    <td class="stack {{ $teacher->email_verified_at == null ? 'unverified' : '' }}">
                                        <span>{{ $teacher->email }}</span>
                                        <span>{{ $teacher->phone_numbers }}</span>
                                    </td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('teachers.edit', $teacher->id) }}">
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
                <p>No teachers yet.</p>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

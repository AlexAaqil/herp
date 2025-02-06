<x-authenticated-layout>
    <x-slot name="head">
        <title>Dorms</title>
    </x-slot>

    <section class="Dorms">
        <div class="body">
            @if ($dorms->isNotEmpty())
                <div class="table">
                    <div class="header">
                        <div class="details">
                            <p class="title">Dorms</p>
                            <p class="stats">
                                <span>{{ $count_dorms }} {{ Str::plural('Dorm', $count_dorms) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('dorms.create') }}">New Dorm</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Name</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($dorms as $dorm)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $dorm->name }}</td>
                                    <td class="actions center">
                                        <div class="action">
                                            <a href="{{ route('dorms.edit', $dorm->id) }}">
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
                <p>No dorms yet.</p>
                <a href="{{ route('dorms.create') }}">New Dorm</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

<x-authenticated-layout>
    <x-slot name="head">
        <title>Textbooks</title>
    </x-slot>

    <section class="Textbooks">
        <div class="body">
            @if ($textbooks->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Textbooks</p>
                            <p class="stats">
                                <span>{{ $count_textbooks }} {{ Str::plural('Textbook', $count_textbooks) }}</span>
                                <span>{{ $count_returned }} Returned</span>
                                <span>{{ $count_lost }} Lost</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('textbooks.create') }}">New Textbook</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Student</th>
                                <th>Textbook</th>
                                <th>Status</th>
                                <th>Issued By</th>
                                <th>Date issued</th>
                                <th>Date returned</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($textbooks as $textbook)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>
                                        <p>{{ $textbook->student->full_name }}</p>
                                        <p>{{ $textbook->student->adm_no }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $textbook->book_name }}</p>
                                        <p>{{ $textbook->book_number }}</p>
                                    </td>
                                    <td class="">{{ ucfirst($textbook->status) }}</td>
                                    <td>{{ $textbook->issuedBy->full_name }}</td>
                                    <td>
                                        @if ($textbook->date_issued)
                                            {{ \Carbon\Carbon::parse($textbook->date_issued)->format('j') }}<sup>{{ \Carbon\Carbon::parse($textbook->date_issued)->format('S') }}</sup> {{ \Carbon\Carbon::parse($textbook->date_issued)->format('M Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($textbook->date_returned)
                                            {{ \Carbon\Carbon::parse($textbook->date_returned)->format('j') }}<sup>{{ \Carbon\Carbon::parse($textbook->date_returned)->format('S') }}</sup> {{ \Carbon\Carbon::parse($textbook->date_returned)->format('M Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('textbooks.edit', $textbook->id) }}">
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
                <p>No textbooks yet.</p>
                <a href="{{ route('textbooks.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

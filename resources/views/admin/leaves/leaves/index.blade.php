<x-authenticated-layout>
    <x-slot name="head">
        <title>Leaves</title>
    </x-slot>

    <section class="Leaves">
        <div class="body">
            @if ($leaves->isNotEmpty())
            <div class="table list_items">
                <div class="header">
                    <div class="details">
                        <p class="title">Leaves</p>
                        <p class="stats">
                            <span>{{ $count_leaves }} {{ Str::plural('Leave', $count_leaves) }}</span>
                            <span>{{ $count_unread }} Unread</span>
                            <span>{{ $count_notanswered }} Unanswered</span>
                        </p>
                    </div>
                    
                    <x-search-input />
                    
                    @cannot('view-as-super-admin')
                    <div class="btn">
                        <a href="{{ route('leaves.create') }}">New Leave</a>
                    </div>
                    @endcannot
                </div>

                @can('view-as-admin')
                <table>
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            @can('view-as-admin')
                                <th>Name</th>
                            @endcan
                            <th>Category</th>
                            <th>Time</th>
                            <th>Reason</th>
                            <th>Response</th>
                            <th class="actions center">Actions</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr class="searchable {{ $leave->status == 1 ? 'read' : '' }}">
                                <td class="center">{{ $loop->iteration }}</td>
                                @can('view-as-admin')
                                    <td>{{ $leave->user->full_name }}</td>
                                @endcan
                                <td>{{ $leave->category }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('j') }}<sup>{{ \Carbon\Carbon::parse($leave->from_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($leave->from_date)->format('M Y') }} to {{ \Carbon\Carbon::parse($leave->to_date)->format('j') }}<sup>{{ \Carbon\Carbon::parse($leave->to_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($leave->to_date)->format('M Y') }}</td>
                                <td>{!! Illuminate\Support\Str::limit($leave->comment, 50, '...') !!}</td>
                                <td>
                                    @if($leave->response == 'pending')
                                        {{ $leave->response }}
                                    @elseif($leave->response == 'rejected')
                                        <span class="fa fa-times-circle"></span>
                                    @else
                                        <span class="fa fa-check-circle"></span>
                                    @endif
                                </td>
                                <td class="actions center">
                                    <div class="action_buttons">
                                        <div class="action">
                                            <a href="{{ route('leaves.edit', $leave->id) }}">
                                                <span class="fas fa-eye"></span> 
                                            </a> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endcan

                @can('view-as-user')
                <div class="items searchable">
                    @foreach ($leaves as $leave)
                        <div class="item">
                            <div class="item_header">
                                <p class="details">
                                    <span>{{ ucfirst($leave->category) }} Leave</span>
                                    <span>
                                        @if($leave->response == 'pending')
                                            {{ ucfirst($leave->response) }}
                                        @elseif($leave->response == 'rejected')
                                            <span class="fa fa-times-circle"></span>
                                        @else
                                            <span class="fa fa-check-circle"></span>
                                        @endif
                                    </span>
                                </p>

                                <p class="actions">
                                    @if($leave->response == 'pending')
                                        <a href="{{ route('leaves.edit', $leave->id) }}">Edit</a>
                                    @else
                                        <span></span>
                                    @endif
                                </p>
                            </div>

                            <div class="content">
                                <p>From {{ $leave->to_date->format('d M / Y') }} to {{ $leave->from_date->format('d M / Y') }}</p>
                                {!! $leave->comment !!}
                            </div>
                        </div>
                        @endforeach
                </div>
                @endcan
            </div>
            @else
                <p>No leaves yet.</p>
                @cannot('view-as-super-admin')
                    <a href="{{ route('leaves.create') }}">Add New</a>
                @endcannot
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

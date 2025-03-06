<x-authenticated-layout>
    <x-slot name="head">
        <title>Inventory Records</title>
    </x-slot>

    <section class="Inventory">
        <div class="system_nav">
            <a href="{{ route('inventory-categories.index') }}">Inventory Categories</a>
            <span>Records</span>
        </div>

        <div class="body">
            @if ($inventory_records->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Inventory</p>
                            <p class="stats">
                                <span>{{ $count_inventory_records }} {{ Str::plural('Record', $count_inventory_records) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('inventory-records.create') }}">New Inventory</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th>Transaction</th>
                                <th>Quantity</th>
                                <th>Remaining</th>
                                <th>Date</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($inventory_records as $record)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $record->item->name }}</td>
                                    <td>{{ $record->transaction }}</td>
                                    <td>{{ $record->quantity }}</td>
                                    <td>{{ $record->remaining ?? '-' }}</td>
                                    <td>{{ $record->date->format('d M Y') }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('inventory-records.edit', $record->id) }}">
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
                <p>No inventory records yet.</p>
                <a href="{{ route('inventory-records.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

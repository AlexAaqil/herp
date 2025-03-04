<x-authenticated-layout>
    <x-slot name="head">
        <title>Payments</title>
    </x-slot>

    <section class="Payments">
        <div class="system_nav">
            <a href="{{ route('payment-records.index') }}">Payment Records</a>
            <span>Payments</span>
        </div>
        <div class="body">
            @if ($grouped_payments)
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">Payments</p>
                        </div>

                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('payments.create') }}">New Payment</a>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Period</th>
                                <th>Payment</th>
                                <th>Amount (Kshs.)</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grouped_payments as $class_name => $periods)
                                @php 
                                    // Total rows for this class
                                    $total_rows = array_sum(array_map('count', $periods));
                                    $show_class = true; 
                                @endphp
                                @foreach ($periods as $period => $payments)
                                    @php $show_period = true; @endphp
                                    @foreach ($payments as $payment)
                                        <tr>
                                            @if ($show_class)
                                                <td rowspan="{{ $total_rows }}">{{ $class_name }}</td>
                                                @php $show_class = false; @endphp
                                            @endif
                        
                                            @if ($show_period)
                                                <td rowspan="{{ count($payments) }}">{{ $period }}</td>
                                                @php $show_period = false; @endphp
                                            @endif
                        
                                            <td>{{ $payment['name'] }}</td>
                                            <td>{{ $payment['amount'] }}</td>
                                            <td class="center">
                                                <a href="{{ route('payments.edit', $payment['id']) }}">
                                                    <span class="fa fa-eye"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>                                                                      
                    </table>
                </div>
            @else
                <p>No payments yet.</p>
                <a href="{{ route('payments.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>
<x-authenticated-layout class="PrintReceipt">
    <x-slot name="head">
        <title>Print Receipt</title>
    </x-slot>

    <section class="Payments">
        @if ($payment_records->isNotEmpty())
            <div class="fees_receipt">
                <div class="receipt_header">
                    <p class="title">Fees Receipt</p>

                    <div class="details">
                        <p>{{ config('globals.app_name') }}</p>
                        <p>
                            {{ config('globals.app_phone_number') }}
                            {{ config('globals.app_phone_other') ? ' / ' . config('globals.app_phone_other') : '' }}
                        </p>
                        <p>{{ config('globals.app_email') }}</p>
                        <p>{{ config('globals.app_address') }}</p>
                    </div>
                </div>

                <div class="receipt_body">
                    <p>
                        <span>Student:</span>
                        <span>{{ $student->full_name }}</span>
                    </p>
                    <p>
                        <span>ADM No:</span>
                        <span>{{ $student->adm_no }}</span>
                    </p>
                    <p>
                        <span>Period:</span>
                        <span>{{ $year . ' Term ' . $term }}</span>
                    </p>
                </div>

                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment For</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_amount = 0;
                                $total_paid = 0;
                                $total_balance = 0;
                            @endphp
                            @foreach ($payment_records as $record)
                                <tr>
                                    <td>{{ $record->payment->name }}</td>
                                    <td>{{ number_format($record->payment->amount, 2) }}</td>

                                    @php
                                        $total_amount += $record->payment->amount;
                                        $total_paid += $record->amount_paid;
                                        $total_balance += $record->balance;
                                    @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td>{{ number_format($total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="payment_details">
                    <p><b>Total Paid: {{ number_format($total_paid, 2) }}</b></p>
                    <p>
                        @if ($total_balance == 0)
                            <span class="success"><b>You don't have any balance</b></span>
                        @else
                            <span class="danger"><b>Balace: {{ number_format($total_balance, 2) }}</b></span>
                        @endif
                    </p>
                </div>

                <p>You were served by: {{ auth()->user()->full_name }}</p>

                <div class="image">
                    <x-bursar-stamp />
                </div>
            </div>
        @elseif($selected_period)
            <p>No payment records available for the selected period.</p>
        @endif
    </section>

    <x-slot name="scripts">
        <script>
            window.addEventListener('load', function() {
                window.print();
                
                setTimeout(function() {
                    window.close();
                }, 100);
            });
        </script>
    </x-slot>
</x-authenticated-layout>
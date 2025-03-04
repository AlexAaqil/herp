<x-authenticated-layout>
    <x-slot name="head">
        <title>Generate Receipt</title>
    </x-slot>

    <section class="Payments">
        <div class="system_nav">
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('payment-records.index') }}">Payment Records</a>
            <span>Print Receipt</span>
        </div>

        <div class="title">
            <p>Generate Receipt for: {{ $student->full_name }} - {{ $student->adm_no }}</p>
        </div>

        <form action="{{ route('payment-records.generate_receipt', $student->id) }}" method="GET">
            <div class="inputs">
                <label for="period">Select Period:</label>
                <select name="period" onchange="this.form.submit()">
                    <option value="">Select Period</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period }}" {{ old('period', $selected_period) == $period ? 'selected' : '' }}>
                            {{ $period }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

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
                        <span>{{ $selected_period }}</span>
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

                <form action="{{ route('payment-records.print_receipt', $student->id) }}" method="post">
                    @csrf

                    @php
                        $payment_record = $payment_records->first();
                    @endphp

                    <input type="hidden" name="payment_record" value="{{ $payment_record->id }}">
                    <input type="hidden" name="year" value="{{ $payment_record->payment->year }}">
                    <input type="hidden" name="term" value="{{ $payment_record->payment->term }}">
                    <button>Print Receipt</button>
                </form>
            </div>
        @elseif($selected_period)
            <p>No payment records available for the selected period.</p>
        @endif
    </section>
</x-authenticated-layout>
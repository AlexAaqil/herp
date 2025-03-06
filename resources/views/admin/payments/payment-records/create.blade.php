<x-authenticated-layout>
    <x-slot name="head">
        <title>Payment Records | Create</title>
    </x-slot>

    <section class="Payments">
        <div class="system_nav">
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('payment-records.index') }}">Payment Records</a>
            <a href="{{ route('payment-records.generate_receipt', $student->id) }}">Fees Receipt</a>
            <a href="{{ route('payment-records.generate_gatepass', $student->id) }}">Gatepass</a>
            {{-- 
            <a href="{{ route('payment-gatepass.select', $payment_records->first()->student->id) }}">Gate Pass</a> 
            --}}
            <span>Manage Payments</span>
        </div>

        <div class="title">
            @if($payment_records->isNotEmpty())
                <p>{{ $student->full_name }} - {{ $student->adm_no }}</p>
                <p>{{ $student->classroom->name }}</p>
            @else
                <p class="title">No payment records available for this student.</p>
            @endif
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Pay Now</th>
                    </tr>
                </thead>
    
                <tbody>
                    @foreach ($payment_records as $period => $records)
                        @foreach($records as $record)
                            <tr>
                                <td>{{ $period }}</td>
                                <td>{{ $record->payment->name }}</td>
                                <td>{{ number_format($record->payment->amount, 2) }}</td>
                                <td class="info">{{ number_format($record->amount_paid, 2) }}</td>
                                <td class="{{ $record->balance == 0 ? 'success' : 'danger' }}">{{ number_format($record->balance, 2) }}</td>
                                <td>
                                    <form action="{{ route('payment-records.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student_id }}">
                                
                                        <div class="inputs">
                                            <input type="number" name="amount_paid[{{ $record->id }}]"
                                                value="{{ old('amount_paid.' . $record->id, '') }}" 
                                                min="0" step="0.01"
                                                placeholder="Amount Paid"
                                                {{ $record->balance == 0 ? 'disabled' : '' }}>
                                            @if ($errors->has("amount_paid.{$record->id}"))
                                                <span class="inline_alert">{{ $errors->first("amount_paid.{$record->id}") }}</span>
                                            @endif
                                        </div>
                                
                                        <div class="inputs">
                                            <select name="payment_method[{{ $record->id }}]" {{ $record->balance == 0 ? 'disabled' : '' }}>
                                                <option value="">Payment Method</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="cash">Cash</option>
                                            </select>
                                            @if ($errors->has("payment_method.{$record->id}"))
                                                <span class="inline_alert">{{ $errors->first("payment_method.{$record->id}") }}</span>
                                            @endif
                                        </div>
                                
                                        <button type="submit" class="btn_info" {{ $record->balance == 0 ? 'disabled' : '' }}>Pay</button>
                                    </form>
                                </td>                                
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-authenticated-layout>

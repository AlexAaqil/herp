<x-authenticated-layout>
    <x-slot name="head">
        <title>Generate Gatepass</title>
    </x-slot>

    <section class="Payments">
        <div class="system_nav">
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('payment-records.create', $student->id) }}">Payment Records</a>
            <a href="{{ route('payment-records.generate_receipt', $student->id) }}">Fees Receipt</a>
            <span>Gatepass</span>
        </div>

        <div class="title">
            <p>Generate Gatepass for: {{ $student->full_name }} - {{ $student->adm_no }}</p>
        </div>

        <form action="{{ route('payment-records.generate_gatepass', $student->id) }}" method="GET">
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
                    <p class="title">Gatepass</p>

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

                
                <div class="gatepass_body">
                    @if($completed_payment)
                        <p>This Gatepass is valid for the period: <b>{{ $selected_period }}</b>.</p>

                        <form action="{{ route('payment-records.print_gatepass', $student->id) }}" method="post">
                            @csrf
        
                            @php
                                $payment_record = $payment_records->first();
                            @endphp

                            <input type="hidden" name="payment_record" value="{{ $payment_record->id }}">
                            <input type="hidden" name="year" value="{{ $payment_record->payment->year }}">
                            <input type="hidden" name="term" value="{{ $payment_record->payment->term }}">
        
                            <button>Print Gatepass</button>
                        </form>
                    @else
                        <form action="{{ route('payment-records.print_gatepass', $student->id) }}" method="post">
                            @csrf
        
                            @php
                                $payment_record = $payment_records->first();
                            @endphp
        
                            <input type="hidden" name="payment_record" value="{{ $payment_record->id }}">
                            <input type="hidden" name="year" value="{{ $payment_record->payment->year }}">
                            <input type="hidden" name="term" value="{{ $payment_record->payment->term }}">
        
                            <input type="text" name="comment" id="comment" placeholder="Enter a comment to generate the gatepass manually" value="{{ old('comment') }}">
        
                            <button>Print Gatepass</button>
                        </form>
                    @endif
                </div>
            </div>
        @elseif($selected_period)
            <p>No payment records available for the selected period.</p>
        @endif
    </section>
</x-authenticated-layout>
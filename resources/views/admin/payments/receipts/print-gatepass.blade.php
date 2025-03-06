<x-authenticated-layout class="PrintReceipt">
    <x-slot name="head">
        <title>Print Gatepass</title>
    </x-slot>

    <section class="Payments">
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
                        <span>{{ $year . ' Term ' . $term }}</span>
                    </p>
                </div>

                <div class="gatepass_body">
                    @if (!empty($comment))
                        <p><strong class="danger">Temporary Gatepass:</strong></p>
                        <p>{{ $comment }}</p>
                    @elseif ($payment_records->isEmpty())
                        <p>No payment records found for the selected term and year.</p>
                    @else
                        <p class="success title">Official Gatepass</p>
                        <p>The student has completed payment and is allowed to use this gatepass for the period: <b>{{ $year . ' Term ' . $term }}</b></p>
                    @endif    
                </div>

                <p>Approved by: {{ auth()->user()->full_name }}</p>
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
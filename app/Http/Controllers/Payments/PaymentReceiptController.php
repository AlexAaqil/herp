<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentReceipt;
use App\Models\Payments\PaymentRecord;
use App\Models\Payments\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReceiptController extends Controller
{
    public function generateReceipt(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
    
        $selected_period = $request->input('period');
        $payment_records = collect();
    
        if ($request->has('period')) {
            $request->validate([
                'period' => 'required|string',
            ]);
    
            // Extract year and term from the selected period
            list($year, $term) = explode(' Term ', $selected_period);
    
            $payment_records = PaymentRecord::with('payment')
                ->where('student_id', $student_id)
                ->whereHas('payment', function ($query) use ($year, $term) {
                    $query->where('year', $year)
                          ->where('term', $term);
                })
                ->get();
        }
    
        // Dynamically fetch years and terms from existing payment records
        $periods = Payment::select(DB::raw('DISTINCT year, term'))
                          ->orderBy('year', 'desc')
                          ->orderBy('term')
                          ->get()
                          ->map(function ($payment) {
                              return $payment->year . ' Term ' . $payment->term;
                          });
    
        return view('admin.payments.receipts.generate-receipt', compact('payment_records', 'student', 'selected_period', 'periods'));
    }

    public function printReceipt(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $payment_record_id = $request->input('payment_record');
        $year = $request->input('year');
        $term = $request->input('term');

        $payment_records = collect();
        $payment_records = PaymentRecord::with('payment')
            ->where('student_id', $student->id)
            ->whereHas('payment', function ($query) use ($year, $term) {
                $query->where('year', $year)
                      ->where('term', $term);
            })
            ->get();
    
        return view('admin.payments.receipts.print-receipt', compact('payment_records', 'student', 'term', 'year'));
    }

    public function generateGatepass(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);

        $selected_period = $request->input('period');
        $payment_records = collect();
    
        if ($request->has('period')) {
            $request->validate([
                'period' => 'required|string',
            ]);
    
            // Extract year and term from the selected period
            list($year, $term) = explode(' Term ', $selected_period);
    
            $payment_records = PaymentRecord::with('payment')
                ->where('student_id', $student_id)
                ->whereHas('payment', function ($query) use ($year, $term) {
                    $query->where('year', $year)
                          ->where('term', $term);
                })
                ->get();
        }
    
        // Dynamically fetch years and terms from existing payment records
        $periods = Payment::select(DB::raw('DISTINCT year, term'))
                          ->orderBy('year', 'desc')
                          ->orderBy('term')
                          ->get()
                          ->map(function ($payment) {
                              return $payment->year . ' Term ' . $payment->term;
                          });

        $completed_payment = $payment_records->sum('balance') <= 0;

        return view('admin.payments.receipts.generate-gatepass', compact('completed_payment', 'payment_records', 'student', 'selected_period', 'periods'));
    }

    public function printGatePass(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $payment_record_id = $request->input('payment_record');
        $year = $request->input('year');
        $term = $request->input('term');

        $comment = $request->input('comment');

        $payment_records = collect();
        $payment_records = PaymentRecord::with('payment')
            ->where('student_id', $student->id)
            ->whereHas('payment', function ($query) use ($year, $term) {
                $query->where('year', $year)
                      ->where('term', $term);
            })
            ->get();


        if (!$student || !$payment_records) {
            return redirect()->back()->with('error', ['message' => 'Payment record data not found.']);
        }
        
        return view('admin.payments.receipts.print-gatepass', compact('comment', 'student', 'payment_records', 'term', 'year'));
    }
}

<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentRecord;
use App\Models\Payments\Payment;
use App\Models\Payments\PaymentReceipt;
use App\Models\Classrooms\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentRecordController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::orderBy('name')->get();
    
        $classroom_id = $request->input('classroom_id');
        $classroom = $classroom_id ? Classroom::find($classroom_id) : null;
        $students = $classroom ? $classroom->students()->orderBy('first_name')->get() : collect();
    
        return view('admin.payments.payment-records.index', compact('classroom_id', 'classroom', 'classrooms', 'students'));
    }

    public function create($student_id, Request $request)
    {
        $student = Student::with('classroom.classroomCategory')->findOrFail($student_id);
    
        if (!$student->classroom || !$student->classroom->classroomCategory) {
            return back()->with('error', 'Student classroom or category not found.');
        }    
        $classroom_category_id = $student->classroom->classroomCategory->id;

        $payments = Payment::where('classroom_category_id', $classroom_category_id)->get();
    
        // Create payment record for the student if it doesn't exist
        foreach ($payments as $payment) {
            PaymentRecord::firstOrCreate(
                [
                    'student_id' => $student_id,
                    'payment_id' => $payment->id,
                ],
                [
                    'amount_paid' => 0,
                    'balance' => $payment->amount,
                ]
            );
        }
    
        $payment_records = PaymentRecord::with('payment')
            ->where('student_id', $student_id)
            ->join('payments', 'payment_records.payment_id', '=', 'payments.id')
            ->orderByDesc('payments.year')
            ->orderBy('payments.term')
            ->select('payment_records.*')
            ->get()
            ->groupBy(function ($record) {
                return $record->payment->year . ' - Term ' . $record->payment->term;
            });;
    
        return view('admin.payments.payment-records.create', compact('payment_records', 'student', 'student_id'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_paid' => 'required|array',
            'amount_paid.*' => 'required|numeric|min:0',
            'payment_method' => 'required|array',
            'payment_method.*' => 'required|string',
        ], [
            'amount_paid.*.required' => 'Amount is required.',
            'amount_paid.required' => 'Amount is required.',
            'payment_method.*' => 'Payment method is required.',
            'payment_method' => 'Payment method is required.',
        ]);
    
        $reference_number = rand(100000, 999999);
    
        DB::beginTransaction();
        try {
            foreach ($request->amount_paid as $recordId => $amountPaid) {
                $paymentRecord = PaymentRecord::findOrFail($recordId);
    
                // Ensure payment method exists for this record
                if (!isset($request->payment_method[$recordId])) {
                    throw new \Exception("Payment method is required for payment ID {$recordId}.");
                }
    
                // Get the corresponding payment method
                $paymentMethod = $request->payment_method[$recordId];
    
                // Validate that the amount being paid does not exceed balance
                if ($amountPaid > $paymentRecord->balance) {
                    throw new \Exception("The amount exceeds the remaining balance for payment ID {$recordId}.");
                }
    
                // Calculate new balance
                $newBalance = $paymentRecord->balance - $amountPaid;
    
                // Update the payment record
                $paymentRecord->amount_paid += $amountPaid;
                $paymentRecord->balance = $newBalance;
                $paymentRecord->save();
    
                // Create a receipt record
                PaymentReceipt::create([
                    'amount_paid' => $amountPaid,
                    'payment_method' => $paymentMethod,
                    'reference_number' => $reference_number,
                    'balance' => $newBalance,
                    'date_paid' => today(),
                    'payment_record_id' => $paymentRecord->id,
                ]);
            }
    
            DB::commit();
            return redirect()->route('payment-records.create', ['student_id' => $request->student_id])
                             ->with('success', 'Payment has been added successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    

    public function destroy(string $id)
    {
        //
    }
}

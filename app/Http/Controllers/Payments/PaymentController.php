<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Classrooms\ClassroomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('classroomCategory')
            ->orderBy('classroom_category_id') 
            ->orderBy('year', 'desc')
            ->orderBy('term')
            ->get();
    
        $grouped_payments = [];
    
        foreach ($payments as $payment) {
            $class_name = $payment->classroomCategory->name;
            $period = "{$payment->year} Term {$payment->term}";
    
            if (!isset($grouped_payments[$class_name])) {
                $grouped_payments[$class_name] = [];
            }
    
            if (!isset($grouped_payments[$class_name][$period])) {
                $grouped_payments[$class_name][$period] = [];
            }
    
            $grouped_payments[$class_name][$period][] = [
                'id' => $payment->id,
                'name' => $payment->name,
                'amount' => number_format($payment->amount, 2),
            ];
        }
    
        return view('admin.payments.payments.index', compact('grouped_payments'));
    }    

    public function create()
    {
        $classes = ClassroomCategory::orderBy('name')->get();

        return view('admin.payments.payments.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated_data = $this->validatePaymentData($request);

        try {
            DB::transaction(function () use ($validated_data) {
                $existing_payment = Payment::where('name', $validated_data['name'])
                    ->where('year', $validated_data['year'])
                    ->where('term', $validated_data['term'])
                    ->where('classroom_category_id', $validated_data['classroom_category_id'])
                    ->first();

                if ($existing_payment) {
                    throw ValidationException::withMessages([
                        'name' => 'Payment record already exists.',
                    ]);
                }

                Payment::create($validated_data);
            });

            return redirect()->route('payments.index')->with('success', 'Payment has been added.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the payment.');
        }
    }

    public function edit(Payment $payment)
    {
        $classes = ClassroomCategory::orderBy('name')->get();

        return view('admin.payments.payments.edit', compact('classes', 'payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated_data = $this->validatePaymentData($request);

        try {
            DB::transaction(function () use ($payment, $validated_data) {
                $existing_payment = Payment::where('name', $validated_data['name'])
                    ->where('year', $validated_data['year'])
                    ->where('term', $validated_data['term'])
                    ->where('classroom_category_id', $validated_data['classroom_category_id'])
                    ->where('id', '!=', $payment->id)
                    ->first();

                if ($existing_payment) {
                    throw ValidationException::withMessages([
                        'name' => 'Payment record already exists.',
                    ]);
                }

                $payment->update($validated_data);
            });

            return redirect()->route('payments.index')->with('success', 'Payment has been updated.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the payment.');
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            DB::transaction(function () use ($payment) {
                $payment->delete();
            });

            return redirect()->route('payments.index')->with('success', 'Payment has been deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the payment.');
        }
    }

    protected function validatePaymentData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric',
            'year' => 'required|numeric',
            'term' => 'required|numeric|in:1,2,3',
            'classroom_category_id' => 'required|exists:classroom_categories,id',
        ]);
    }
}
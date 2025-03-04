<x-authenticated-layout>
    <x-slot name="head">
        <title>Payment Records</title>
    </x-slot>

    <section class="Payments">
        <div class="system_nav">
            <a href="{{ route('payments.index') }}">Payments</a>
            <span>Payment Records</span>
        </div>

        <div class="body">
            <form action="{{ route('payment-records.index') }}" method="get">                    
                <select name="classroom_id" id="classroom_id" onchange="this.form.submit()">
                    <option value="">Select Classroom</option>
                    @foreach($classrooms as $classroomOption)
                        <option value="{{ $classroomOption->id }}" {{ $classroom_id == $classroomOption->id ? "selected" : "" }}>
                            {{ $classroomOption->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error field="classroom_id" />
            </form>

            @if($students->isNotEmpty())
                <p class="title">Students in {{ $classroom->name ?? 'Selected Classroom' }}</p>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <p>{{ $student->full_name }}</p>
                                        <p>{{ $student->adm_no }}</p>
                                    </td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('payment-records.create', $student->id) }}">
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
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

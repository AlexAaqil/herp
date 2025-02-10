<x-authenticated-layout>
    <x-slot name="head">
        <x-searchable-select-header />
        <title>Leaveout | Update</title>
    </x-slot>

    <section class="Leaves">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('leaveouts.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Leaveout</p>
            </div>

            <form action="{{ route('leaveouts.update', $leaveout->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group">
                    <div class="inputs">
                        <label for="student_id">Student</label>
                        <select name="student_id" id="student_id" class="searchable_select">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $leaveout->student_id) == $student->id ? 'selected' : '' }}>{{ $student->adm_no.' - '.$student->full_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="student_id" />
                    </div>

                    <div class="inputs">
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="">Select Leave Category</option>
                            @foreach(App\Models\Leaveout::CATEGORIES as $category)
                                <option value="{{ $category }}" {{old('category', $leaveout->category) == $category ? 'selected' : ''}}>{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="category" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="from_date">From Date</label>
                        <input 
                            type="date" 
                            name="from_date" 
                            id="from_date" 
                            value="{{ old('from_date', $leaveout->from_date->format('Y-m-d')) }}" 
                            min="{{ now()->format('Y-m-d') }}" 
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <x-input-error field="from_date" />
                    </div>
    
                    <div class="inputs">
                        <label for="to_date">To Date</label>
                        <input 
                            type="date" 
                            name="to_date" 
                            id="to_date" 
                            value="{{ old('to_date', $leaveout->to_date->format('Y-m-d')) }}" 
                            min="{{ now()->format('Y-m-d') }}" 
                            max="{{ now()->addMonths(2)->format('Y-m-d') }}">
                        <x-input-error field="to_date" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="comment">Reason</label>
                    <textarea name="comment" id="editor_ckeditor" cols="30" rows="10" placeholder="Reason for this leave">{{ old('comment', $leaveout->comment) }}</textarea>
                    <x-input-error field="comment" />
                </div>

                <div class="buttons">
                    <button type="submit">Update Leaveout</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $leaveout->id }}, 'leaveout');"
                        form="deleteForm_{{ $leaveout->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Leaveout</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $leaveout->id }}" action="{{ route('leaveouts.destroy', $leaveout->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
        <x-text-editor />
        <x-searchable-select-js />
    </x-slot>
</x-authenticated-layout>

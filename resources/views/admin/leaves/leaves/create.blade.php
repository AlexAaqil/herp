<x-authenticated-layout>
    <x-slot name="head">
        <title>Leave | Apply for leave</title>
    </x-slot>

    <section class="Leaves">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('leaves.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Leave Application Form</p>
            </div>

            <form action="{{ route('leaves.store') }}" method="post">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

               <div class="input_group_3">
                    <div class="inputs">
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="">Select Leave Category</option>
                            @foreach (App\Models\Leave::CATEGORIES as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="category" />
                    </div>

                    <div class="inputs">
                        <label for="from_date">From Date</label>
                        <input 
                            type="date" 
                            name="from_date" 
                            id="from_date" 
                            value="{{ old('from_date') }}"
                            min="{{ now()->format('Y-m-d') }}" 
                            max="{{ now()->addMonths(1)->format('Y-m-d') }}">
                        <x-input-error field="from_date" />
                    </div>
    
                    <div class="inputs">
                        <label for="to_date">To Date</label>
                        <input 
                            type="date" 
                            name="to_date" 
                            id="to_date" 
                            value="{{ old('to_date') }}" 
                            min="{{ now()->format('Y-m-d') }}" 
                            max="{{ now()->addMonths(1)->format('Y-m-d') }}">
                        <x-input-error field="to_date" />
                    </div>
               </div>

                <div class="inputs">
                    <label for="comment">Reason</label>
                    <textarea name="comment" id="editor_ckeditor" cols="30" rows="10" placeholder="Reason for this leave">{{ old('comment') }}</textarea>
                    <x-input-error field="comment" />
                </div>

                <button type="submit">Apply for Leave</button>
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>

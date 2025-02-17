<x-authenticated-layout>
    <x-slot name="head">
        <title>Leave | Update</title>
    </x-slot>

    <section class="Leaves">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('leaves.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Leave</p>
            </div>

            <form action="{{ route('leaves.update', $leave->id) }}" method="post">
                @csrf
                @method('patch')

                @can('view-as-admin')
                    <div class="form_details">
                        <p>
                            <span>Name:</span>
                            <span>
                                {{ $leave->user->full_name }} 
                                <span class="badge">{{ $leave->user->user_level_label }}</span>
                            </span>
                        </p>
                        <p>
                            <span>Email:</span>
                            <span>{{ $leave->user->email }}</span>
                        </p>
                        <p>
                            <span>Tel:</span>
                            <span>{{ $leave->user->phone_numbers ? $leave->user->phone_numbers : '-' }}</span>
                        </p>
                        <p>
                            <span>Category:</span>
                            <span>{{ $leave->category }}</span>
                        </p>
                        <p>
                            <span>Time: </span>
                            <span>{{ \Carbon\Carbon::parse($leave->from_date)->format('j') }}<sup>{{ \Carbon\Carbon::parse($leave->from_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($leave->from_date)->format('M Y') }} to {{ \Carbon\Carbon::parse($leave->to_date)->format('j') }}<sup>{{ \Carbon\Carbon::parse($leave->to_date)->format('S') }}</sup> {{ \Carbon\Carbon::parse($leave->to_date)->format('M Y') }}</span>
                        </p>
                        <div>
                            <p>Reason:</p>
                            {!! $leave->comment !!}
                        </div>
                    </div>

                    @if ($leave->response == 'pending')
                        <div class="inputs">
                            <label for="response">Response</label>
                            <div class="custom_radio_buttons">
                                @foreach(App\Models\Leave::RESPONSES as $response)
                                    <label>
                                        <input class="option_radio" 
                                            type="radio" 
                                            name="response" 
                                            value="{{ $response }}"
                                            {{ old('response', $leave->response) == $response ? 'checked' : '' }}>
                                        <span>{{ ucfirst($response) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error field="response" />
                        </div>
                    @else
                        <p>This leave has been <b>{{ $leave->response }}</b></p>
                    @endif
                @endcan

                @can('view-as-user')
                    @if ($leave->response == 'pending')
                        <div class="input_group_3">
                            <div class="inputs">
                                <label for="category">Category</label>
                                <select name="category" id="category">
                                    <option value="">Select Leave Category</option>
                                    @foreach (App\Models\Leave::CATEGORIES as $category)
                                        <option value="{{ $category }}" {{ old('category', $leave->category) == $category ? 'selected' : '' }}>
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
                                    value="{{ old('from_date', $leave->from_date->format('Y-m-d')) }}"
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
                                    value="{{ old('to_date', $leave->to_date->format('Y-m-d')) }}" 
                                    min="{{ now()->format('Y-m-d') }}" 
                                    max="{{ now()->addMonths(1)->format('Y-m-d') }}">
                                <x-input-error field="to_date" />
                            </div>
                        </div>

                        <div class="inputs">
                            <label for="comment">Reason</label>
                            <textarea name="comment" id="editor_ckeditor" cols="30" rows="10" placeholder="Reason for this leave">{{ old('comment', $leave->comment) }}</textarea>
                            <x-input-error field="comment" />
                        </div>
                    @else
                        <p>You can only update leave details when the response is pending.</p>
                    @endif
                @endcan

                <div class="buttons">
                    @if ($leave->response == 'pending')
                        <button type="submit">Update Leave</button>
                    @endif

                    @can('view-as-admin')
                    <button type="button" class="btn_danger" onclick="deleteItem({{ $leave->id }}, 'leave');"
                        form="deleteForm_{{ $leave->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Leave</span>                        
                    </button>
                    @endcan
                </div>
            </form>

            <form id="deleteForm_{{ $leave->id }}" action="{{ route('leaves.destroy', $leave->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
        <x-text-editor />
    </x-slot>
</x-authenticated-layout>
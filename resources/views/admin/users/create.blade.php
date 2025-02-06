<x-authenticated-layout>
    <x-slot name="head">
        <title>User | New</title>
    </x-slot>

    <section class="Users">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('users.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New User</p>
            </div>

            <form action="{{ route('users.store') }}" method="post">
                @csrf

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="user_level" class="required">User Level</label>
                        <div class="custom_radio_buttons">
                            @foreach(App\Models\User::USERLEVELS as $key => $label)
                                <label>
                                    <input class="option_radio" 
                                        type="radio" 
                                        name="user_level" 
                                        value="{{ $key }}"
                                        {{ old('user_level', 2) == $key ? 'checked' : '' }}>
                                    <span>{{ ucfirst($label) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error field="user_level" />
                    </div>

                    <div class="inputs">
                        <label for="emp_code">Employee Code</label>
                        <input type="text" name="emp_code" id="emp_code" placeholder="Employee Code" value={{ old('emp_code') }}>
                        <x-input-error field="emp_code" />
                    </div>

                    <div class="inputs">
                        <label for="emp_date">Employment Date</label>
                        <input type="date" name="emp_date" id="emp_date" value={{ old('emp_date') }}>
                        <x-input-error field="emp_date" />
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="email" class="required">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Email Address"
                            value="{{ old('email') }}">
                        <span class="inline_alert">{{ $errors->first('email') }}</span>
                    </div>

                    <div class="inputs">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" name="first_name" id="first_name" placeholder="First Name"
                            value={{ old('first_name') }}>
                        <span class="inline_alert">{{ $errors->first('first_name') }}</span>
                    </div>
    
                    <div class="inputs">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                            value={{ old('last_name') }}>
                        <span class="inline_alert">{{ $errors->first('last_name') }}</span>
                    </div>
                </div>

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="gender">Gender</label>
                        <div class="custom_radio_buttons">
                            <label>
                                <input class="option_radio" 
                                    type="radio" 
                                    name="gender" 
                                    value="M"
                                    {{ old('gender', 'M') === 'M' ? 'checked' : '' }}>
                                <span>Male</span>
                            </label>

                            <label>
                                <input class="option_radio" 
                                    type="radio" 
                                    name="gender" 
                                    value="F"
                                    {{ old('gender') === 'F' ? 'checked' : '' }}>
                                <span>Female</span>
                            </label>
                        </div>
                        <x-input-error field="gender" />
                    </div>

                    <div class="inputs">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                        <x-input-error field="phone_number" />
                    </div>
                </div>

                <div class="input_group">
                    <div class="inputs">
                        <label for="password">Password</label>
                        <input type="text" name="password" id="password" placeholder="Password">
                        <x-input-error field="password" />
                    </div>
    
                    <div class="inputs">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        <x-input-error field="password confirmation" />
                    </div>
                </div>

                <button type="submit">Add User</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>
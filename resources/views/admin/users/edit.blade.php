<x-authenticated-layout class="Users">
    <div class="custom_form">
        <header>
            <p>Update User</p>

            <div class="navigation">
                <a href="{{ route('users.index') }}">Users</a>
                <span>/ Update</span>
            </div>
        </header>

        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
            @csrf
            @method('PATCH')

            <div class="row_input_group">
                <div class="input_group">
                    <label for="user_level" class="required">User Level</label>
                    @php
                        $selectedUserLevel = old('user_level', $user->user_level);
                    @endphp
                    <select name="user_level" id="user_level" required>
                        <option value="" disabled {{ empty($selectedUserLevel) ? 'selected' : '' }}>Select User
                            Level</option>
                        @foreach ($user_levels as $user_level)
                            <option value="{{ $user_level->user_level }}"
                                {{ $selectedUserLevel == $user_level->user_level ? 'selected' : '' }}>
                                {{ $user_level->title }}
                            </option>
                        @endforeach
                    </select>
                    <span class="inline_alert">{{ $errors->first('user_level') }}</span>
                </div>

                <div class="input_group">
                    <label for="emp_code">Employee Code</label>
                    <input type="text" name="emp_code" id="emp_code" placeholder="Employee Code"
                        value={{ old('emp_code', $user->emp_code) }}>
                    <span class="inline_alert">{{ $errors->first('emp_code') }}</span>
                </div>
            </div>

            <div class="row_input_group">
                <div class="input_group">
                    <label for="first_name" class="required">First Name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="First Name"
                        value={{ old('first_name', $user->first_name) }}>
                    <span class="inline_alert">{{ $errors->first('first_name') }}</span>
                </div>

                <div class="input_group">
                    <label for="last_name" class="required">Last Name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                        value={{ old('last_name', $user->last_name) }}>
                    <span class="inline_alert">{{ $errors->first('last_name') }}</span>
                </div>
            </div>

            <div class="row_input_group">
                <div class="input_group">
                    <label for="email">Email Address (Can't be updated)</label>
                    <input type="email" class="danger" name="email" id="email" placeholder="Email Address"
                        value="{{ old('email', $user->email) }}" disabled>
                    <span class="inline_alert">{{ $errors->first('email') }}</span>
                </div>

                <div class="input_group">
                    <label for="phone_main" class="required">Phone Number</label>
                    <input type="text" name="phone_main" id="phone_main" placeholder="Phone Number"
                        value="{{ old('phone_main', $user->phone_main) }}">
                    <span class="inline_alert">{{ $errors->first('phone_main') }}</span>
                </div>
            </div>

            <div class="row_input_group">
                <div class="input_group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password"
                        placeholder="Leave as blank for generated password">
                    <span class="inline_alert">{{ $errors->first('password') }}</span>
                </div>

                <div class="input_group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="text" name="password_confirmation" id="password_confirmation"
                        placeholder="Leave as blank for generated password">
                    <span class="inline_alert">{{ $errors->first('password_confirmation') }}</span>
                </div>
            </div>

            <div class="buttons">
                <button type="submit">Update</button>

                <button type="button" class="btn_danger" onclick="deleteItem({{ $user->id }}, 'user');"
                    form="deleteForm_{{ $user->id }}">
                    <i class="fas fa-trash-alt delete"></i>
                    <span>Delete</span>
                </button>
            </div>
        </form>

        <form id="deleteForm_{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="post"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <x-slot name="javascript">
        <x-sweetalert />
    </x-slot>
</x-authenticated-layout>

<aside>
    @php
        $user = Auth::user();
        $user_level_label = $user->user_level_label;
    @endphp

    <div class="header">
        <a href="{{ route('profile.edit') }}">
            @if($user->image)
                <img src="{{ asset('storage/' . ($user->image)) }}" alt="User Image" width="25" height="25">
            @else
                <x-default-profile-image width="25" height="25" />
            @endif
        </a>
        <span class="text">
            {{ $user->first_name . ' ' . $user->last_name }}
            <span>{{ $user->email }}</span>
        </span>
    </div>

    @php
        $nav_content = collect([
            [
                'route' => 'dashboard',
                'icon' => 'fas fa-home',
                'text' => 'Dashboard',
                'level' => [],
            ],
            [
                'route' => 'users.index',
                'icon' => 'fas fa-users',
                'text' => 'Staff',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'teachers.index',
                'icon' => 'fas fa-chalkboard-teacher',
                'text' => 'Teachers',
                'level' => ['super admin', 'admin'],
            ],
            // [
            //     'route' => 'guardians.index',
            //     'icon' => 'fas fa-user-friends',
            //     'text' => 'Parents',
            //     'level' => ['super admin', 'admin'],
            // ],
            [
                'route' => 'students.index',
                'icon' => 'fas fa-user-tie',
                'text' => 'Students',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'payment-records.index',
                'icon' => 'fas fa-money-bill-alt',
                'text' => 'Payments',
                'level' => ['super admin', 'admin', 'accountant'],
            ],
            // [
            //     'route' => 'expenses.index',
            //     'icon' => 'fas fa-money-check',
            //     'text' => 'Expenses',
            //     'level' => ['super admin', 'admin', 'teacher'],
            // ],
            [
                'route' => 'inventory-categories.index',
                'icon' => 'fas fa-barcode',
                'text' => 'Inventory',
                'level' => ['super admin', 'admin', 'store keeper'],
            ],
            [
                'route' => 'leaveouts.index',
                'icon' => 'fas fa-calendar-minus',
                'text' => 'Leaveouts',
                'level' => ['super admin', 'admin', 'teacher'],
            ],
            [
                'route' => 'leaves.index',
                'icon' => 'fas fa-calendar-week',
                'text' => 'Leaves',
                'level' => [],
            ],
            // [
            //     'route' => 'announcements.index',
            //     'icon' => 'fas fa-bell',
            //     'text' => 'Leaves',
            //     'level' => ['super admin', 'admin', 'teacher'],
            // ],
            [
                'route' => 'disciplinaries.index',
                'icon' => 'fas fa-balance-scale',
                'text' => 'Disciplinaries',
                'level' => ['super admin', 'admin', 'teacher'],
            ],
            [
                'route' => 'exams.index',
                'icon' => 'fas fa-user-graduate',
                'text' => 'Exams',
                'level' => ['super admin', 'admin', 'teacher'],
            ],
            [
                'route' => 'assignments.index',
                'icon' => 'fas fa-brain',
                'text' => 'Assignments',
                'level' => ['super admin', 'admin', 'teacher'],
            ],
            [
                'route' => 'textbooks.index',
                'icon' => 'fas fa-book',
                'text' => 'Textbooks',
                'level' => ['super admin', 'admin', 'teacher'],
            ],
            [
                'route' => 'classrooms.index',
                'icon' => 'fas fa-chalkboard',
                'text' => 'Classrooms',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'dorms.index',
                'icon' => 'fas fa-house-user',
                'text' => 'Dorms',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'subjects.index',
                'icon' => 'fas fa-book-reader',
                'text' => 'Subjects',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'grades.index',
                'icon' => 'fas fa-award',
                'text' => 'Grades',
                'level' => ['super admin', 'admin'],
            ],
            [
                'route' => 'messages.index',
                'icon' => 'fas fa-comment',
                'text' => 'Messages',
                'level' => ['super admin', 'admin'],
            ],
        ]);

        $nav_links = $nav_content->filter(function($link) use($user_level_label) {
            return empty($link['level']) || in_array($user_level_label, $link['level']);
        });
    @endphp

    <ul class="links">
        @foreach ($nav_links as $link)
            <li class="link {{ Route::currentRouteName() === $link['route'] ? 'active' : '' }}">
                <a href="{{ route($link['route']) }}">
                    <i class="{{ $link['icon'] }}"></i>
                    <span class="text">{{ $link['text'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="footer">
        <div class="logout">
            <form action="{{ route('logout') }}" method="post">
                @csrf

                <button type="submit">
                    <span class="text">Logout</span>
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

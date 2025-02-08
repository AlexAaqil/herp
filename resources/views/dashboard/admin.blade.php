<section class="AdminDashboard">
    <div class="section stats">
        <div class="stat">
            <span>{{ $count_users }}</span>
            <span>Staff members out of {{ $count_all_users }} users</span>
        </div>

        <div class="stat">
            <span>{{ $count_teachers }}</span>
            <span>Teachers out of {{ $count_all_users }} users</span>
        </div>

        <div class="stat">
            <span>{{ $count_classrooms }}</span>
            <span>Classrooms and {{ $count_dorms }} dorms</span>
        </div>

        <div class="stat">
            <span>xxx</span>
            <span>Out of xxx users</span>
        </div>

        <div class="stat">
            <span>xxx</span>
            <span>Out of xxx users</span>
        </div>
    </div>

    <div class="section messages">
        <p class="title">{{ $count_unread_messages }} Unread Messages</p>
        @foreach($unread_messages as $message)
            <div class="message">
                <p class="stack">
                    <a href="{{ route('messages.edit', $message->id) }}">
                        {{ $message->excerpt }}
                    </a>
                    <span>{{ $message->name }}</span>
                </p>
            </div>
        @endforeach
    </div>
</section>
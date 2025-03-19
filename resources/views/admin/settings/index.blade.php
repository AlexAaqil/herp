<x-authenticated-layout>
    <x-slot name="head">
        <title>Settings</title>
    </x-slot>

    <section class="Settings">
        <div class="body">
            <div class="table">
                <div class="header">
                    <div class="details">
                        <p class="title">School Information</p>
                    </div>

                    <div class="btn">
                        <a href="{{ route('settings.edit') }}">Edit</a>
                    </div>
                </div>

                <p>
                    <span>School Name:</span>
                    <span>{{ $settings->school_name ?? '-' }}</span>
                </p>
                <p>
                    <span>School Acronym:</span>
                    <span>{{ $settings->school_acronym ?? '-' }}</span>
                </p>
                <p>
                    <span>School Address:</span>
                    <span>{{ $settings->school_address ?? '-' }}</span>
                </p>
                <p>
                    <span>School Phone Number:</span>
                    <span>{{ $settings->school_phone_number ?? '-' }}</span>
                </p>
                <p>
                    <span>Other School Phone Number:</span>
                    <span>{{ $settings->school_phone_other ?? '-' }}</span>
                </p>
                <p>
                    <span>School Email:</span>
                    <span>{{ $settings->school_email ?? '-' }}</span>
                </p>
                <p>
                    <span>Current Year:</span>
                    <span>{{ $settings->current_year ?? '-' }}</span>
                </p>
                <p>
                    <span>Current Term:</span>
                    <span>Term {{ $settings->current_term ?? '-' }}</span>
                </p>
                <p>
                    <span>Term Begins:</span>
                    <span>{{ ($settings && $settings->term_begins) ? $settings->term_begins->format('d-m-Y') : '-' }}</span>
                </p>
                <p>
                    <span>Term Ends:</span>
                    <span>{{ ($settings && $settings->term_ends) ? $settings->term_ends->format('d-m-Y') : '-' }}</span>
                </p>

                <div class="images">
                    <div class="image">
                        <img src="{{ $settings->principal_stamp }}" alt="Principal's Stamp" width="150" height="150">
                        <p>Principal's Stamp</p>
                    </div>

                    <div class="image">
                        <img src="{{ $settings->bursar_stamp }}" alt="Bursar's Stamp" width="150" height="150">
                        <p>Bursar's Stamp</p>
                    </div>

                    <div class="image">
                        <img src="{{ $settings->storekeeper_stamp }}" alt="Storekeeper's Stamp" width="150" height="150">
                        <p>Storekeeper's Stamp</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>

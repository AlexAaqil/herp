<footer>
    <div class="container">
        <section class="branding">
            <p class="title">{{ $appSettings['school_name'] ?? config('globals.app_name') }}</p>
            <p>School Management Made Easy.</p>
            <p>{{ $appSettings['app_address'] ?? config('globals.app_address') }}</p>

            <p>
                {{ $appSettings['app_phone_number'] ?? config('globals.app_phone_number') }}
                @if(!empty($appSettings['app_phone_other']))
                    / {{ $appSettings['app_phone_other'] }}
                @endif
                @if(!empty(config('globals.app_phone_other')))
                    / {{ config('globals.app_phone_other') }}
                @endif
            </p>
            <p>{{ $appSettings['app_email'] ?? config('globals.app_email') }}</p>

            <div class="socials">
                <a href="https://wa.me/{{ $appSettings['whatsapp_number'] ?? config('globals.app_whatsapp_number') }}">
                    <img src="{{ asset('assets/images/whatsapp.png') }}" alt="{{ config('globals.app_name') }} Whatsapp" width="25" height="25">
                </a>

                <a href="#">
                    <img src="{{ asset('assets/images/instagram.png') }}" alt="{{ config('globals.app_name') }} Instagram" width="25" height="25">
                </a>
            </div>
        </section>

        <section class="links">
            <p class="title">Quick Links</p>
            <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}">Home</a>
            <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}">About</a>
            <a href="{{ Route::has('services-page') ? route('about-page') : '#' }}">Services</a>
            <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}">Contact</a>
            <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}">Blog</a>
        </section>

        <section class="links">
            <p class="title">Resources</p>
            <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}">User Guide</a>
            <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}">FAQs</a>
            <a href="{{ Route::has('services-page') ? route('about-page') : '#' }}">Support</a>
            <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}">Community</a>
        </section>

        <section class="links">
            <p class="title">Legal</p>
            <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}">Terms of Service</a>
            <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}">Security</a>
        </section>
    </div>

    <p class="copyright">&copy; 2024 | {{ config('globals.app_name') }} | All rights reserved</p>
</footer>
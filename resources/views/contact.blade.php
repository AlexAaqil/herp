<x-guest-layout class="ContactPage">
    <x-slot name="head">
        <title>Contact Us | {{ config('globals.app_name') }}</title>
        <meta name="description" content="Home page description">
        <meta name="keywords" content="home, website, example">
    </x-slot>

    <section class="Hero">
        <div class="container">
            <div class="contact_details">
                <div class="header">
                    <h1>Contact Us</h1>
                    <p>Use the details below or fill out the form to get in touch with us for any inquiries, support and partnership opportunities.</p>
                </div>

                <div class="contact">
                    <div class="details">
                        <div class="detail">
                            <img src="{{ asset('assets/images/email.png') }}" alt="Email" width="30" height="30">
                            <p>{{ config('globals.app_email') }}</p>
                        </div>

                        <div class="detail">
                            <img src="{{ asset('assets/images/telephone.png') }}" alt="Telephone" width="30" height="30">
                            <p>
                                <span>{{ config('globals.app_phone_number') }}</span>
                                @if(!empty(config('globals.app_phone_other')))
                                    <span>{{ config('globals.app_phone_other') }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="detail">
                            <img src="{{ asset('assets/images/clock.png') }}" alt="Clock" width="30" height="30">
                            <p>
                                <span>Mon to Fri</span>
                                <span>08:00 A.M - 05:00 P.M</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact_form">
                <form action="{{ route('messages.store') }}" method="post">
                    @csrf

                    <div class="inputs">
                        <input type="text" name="name" id="name" placeholder="" value="{{ old('name') }}">
                        <label for="name">First Name</label>
                        <x-input-error field="name" />
                    </div>

                    <div class="inputs">
                        <input type="email" name="email" id="email" placeholder="" value="{{ old('email') }}">
                        <label for="email">Email Address</label>
                        <x-input-error field="email" />
                    </div>

                    <div class="inputs">
                        <input type="text" name="phone_number" id="phone_number" placeholder="" value="{{ old('phone_number') }}">
                        <label for="phone_number">Phone Number</label>
                        <x-input-error field="phone_number" />
                    </div>

                    <div class="inputs">
                        <textarea name="message" id="message" rows="7" cols="30" placeholder="">{{ session('success') ? '' : request('message', old('message')) }}</textarea>
                        <label for="message">Your message</label>
                        <x-input-error field="message" />
                    </div>

                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>

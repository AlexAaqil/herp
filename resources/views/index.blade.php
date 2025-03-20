<x-guest-layout class="HomePage">
    <x-slot name="head">
        <title>Home | {{ config('globals.app_name') }}</title>
        <meta name="description" content="Home page description">
        <meta name="keywords" content="home, website, example">
    </x-slot>

    <section class="Hero">
        <div class="container">
            <div class="text">
                <h1 class="title">Simplified School Management</h1>
                <p class="sub_title">School Management does not have to be a tasle.</p>
                <div class="btns">
                    <a href="{{ route('login') }}">Get Started</a>
                </div>
            </div>

            <div class="image">
                <img src="{{ asset('assets/images/hero.jpg') }}" alt="{{ config('globals.app_name') }} Hero Image" width="400" height="400">
            </div>
        </div>
    </section>

    <section class="About">
        <div class="container">
            <div class="header">
                <h2>About {{ config('globals.app_acronym') }}</h2>
            </div>

            <div class="content">
                <div class="text">
                    <p>{{ config('globals.app_acronym') }} helps you manage all school operations seamlessly.</p>
                    <ul>
                        <li>Academic Perfomance</li>
                        <li>Student's Assignments</li>
                        <li>Teacher's Schedules</li>
                        <li>School Financials</li>
                        <li>School Inventory</li>
                        <li>Staff Leave Management</li>
                    </ul>
                </div>

                <div class="image">
                    <img src="{{ asset('assets/images/hero.jpg') }}" alt="{{ config('globals.app_name') }} About Image" width="300" height="300">
                </div>
            </div>
        </div>
    </section>

    <section class="Pricing">
        <div class="container">
            <div class="header">
                <h2>Pricing</h2>
                <p>Affordable for any school size</p>
            </div>

            <div class="content">
                <div class="card">
                    <p class="title">
                        <span>One Time Purchase</span>
                        <span>Ksh. 150,000/=</span>
                    </p>
                    <p>What you get</p>
                    <ul>
                        <li>System Installation</li>
                        <li>Student Management</li>
                        <li>Staff Management</li>
                        <li>Academic Performace Reports</li>
                        <li>Downloadable Assignments</li>
                    </ul>
                </div>

                <div class="card">
                    <p class="title">
                        <span>Rolling Purchase</span>
                        <span>Ksh. 150,000/=</span>
                    </p>
                    <p>What you get</p>
                    <ul>
                        <li>System Installation</li>
                        <li>Student Management</li>
                        <li>Staff Management</li>
                        <li>Academic Performace Reports</li>
                        <li>Downloadable Assignments</li>
                        <li>Software Maintenance & Updates</li>
                        <li>Technical Support</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="FAQ">
        <div class="container">
            <div class="header">
                <h2>FAQ</h2>
                <p>Some of the most common questions we get</p>
            </div>

            <div class="content">
                <div class="question_answer">
                    <p class="question">What is {{ config('globals.app_name') }}?</p>
                    <p class="answer">We help schools manage their daily tasks efficiently.</p>
                </div>

                <div class="question_answer">
                    <p class="question">What is the security like?</p>
                    <p class="answer">We implement robust security measures, including encrypted data storage, role-based access control, and two-factor authentication (2FA) for enhanced security.</p>
                </div>

                <div class="question_answer">
                    <p class="question">How do teachers and students access the system?</p>
                    <p class="answer">Teachers and parents can securely log in using their provided credentials. The system supports email-based login, password recovery, and two-factor authentication for extra security.</p>
                </div>

                <div class="question_answer">
                    <p class="question">How do I reach out for technical support?</p>
                    <p class="answer">We offer a 24/7 customer support, training sessions for your staff, teachers and students.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="CTA">
        <div class="container">
            <p class="title">Have any questions?</p>
            <p>Reach out to us for inquiries, support or parternship opportunities. Or send us a message and we will get back to you ASAP.</p>
            <button onclick="location.href='{{ route('contact-page') }}'">Contact Us</button>
        </div>
    </section>
</x-guest-layout>

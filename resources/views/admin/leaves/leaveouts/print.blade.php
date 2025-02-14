<x-authenticated-layout class="PrintLeaveout">
    <x-slot name="head">
        <title>Leaveout | Print</title>
    </x-slot>

    <section class="PrintableArea">
        <div class="container">
            <div class="header">
                <div class="image">
                    <img src="{{ Vite::asset('resources/images/default_image.jpg') }}" alt="School Logo" width="150px" height="150px">
                </div>

                <div class="text">
                    <p class="title">{{ config('globals.app_name') }}</p>
                    <p>Student Leavout Sheet</p>
                </div>
            </div>

            <div class="body">
                <div class="student_details">
                    <p>
                        <span>Adm No:</span>
                        <span>{{ $leaveout->student->adm_no }}</span>
                    </p>
                    <p>
                        <span>Name:</span>
                        <span>{{ $leaveout->student->full_name }}</span>
                    </p>
                    <p>
                        <span>Class:</span>
                        <span>{{ $leaveout->student->classroom->name }}</span>
                    </p>
                </div>

                <div class="content">
                    <p>This is to confirm that the student has been granted a leaveout by <b>{{ $leaveout->createdBy->full_name }}</b>. This leaveout is only valid from <b>{{ $leaveout->from_date->format('D d / m / Y') }}</b> to <b>{{ $leaveout->to_date->format('D d / m / Y') }}</b>.</p>
                    <p><b>Reason for the leaveout:</b></p>
                    <p>{!! $leaveout->comment !!}</p>
                </div>

                <div class="image">
                    <img src="{{ Vite::asset('resources/images/stamp.png') }}" alt="School Stamp" width="180px" height="180px">
                </div>

                <div class="no_print">
                    <button onclick="window.printPrintableArea()" class="btn_info">Print</button>
                    <button class="btn_link">
                        <a href="{{ route('leaveouts.index') }}">Back to Leavouts</a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            function printPrintableArea() {
                // Get the content of the .PrintableArea
                const printableArea = document.querySelector('.PrintableArea').innerHTML;
        
                // Create a new window
                const printWindow = window.open('', '_blank');
        
                // Write the content to the new window
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Print Leaveout</title>
                            <style>
                                .PrintLeaveout {
                                    width: 100dvw;
                                    height: 100dvh;
                                    margin: 0;
                                    padding: 0;
                                    page-break-inside: avoid;
                                    page-break-after: avoid;
                                }

                                .no_print {
                                    display: none;
                                }

                                .PrintLeaveout .PrintableArea {
                                    width: 100%;
                                    height: 100%;
                                    margin: 0;
                                }

                                .PrintLeaveout .PrintableArea .header {
                                    display: grid;
                                    grid-template-columns: 120px 1fr;
                                    align-items: center;
                                    gap: 0.4em;
                                }

                                .PrintLeaveout .PrintableArea .body {
                                    position: relative;
                                }

                                .PrintLeaveout .PrintableArea .body .content {
                                    margin: 2em 0 0;
                                }

                                .PrintLeaveout .PrintableArea .body img {
                                    width: 120px;
                                    height: 120px;
                                    position: absolute;
                                    top: -1.2em;
                                    right: 18%;
                                    transform: rotate(-30deg);
                                    z-index: -1;
                                }

                                .PrintLeaveout .PrintableArea .header .title {
                                    font-size: 1.2em;
                                    font-weight: bold;
                                }
                            </style>
                        </head>
                        <body>
                            <main class="PrintLeaveout">
                                <section class="PrintableArea">
                                    ${printableArea}
                                </section>
                            </main>
                        </body>
                    </html>
                `);
        
                // Close the document to ensure it's ready for printing
                printWindow.document.close();
        
                // Trigger the print dialog
                printWindow.print();
            }
        </script>
    </x-slot>
</x-authenticated-layout>

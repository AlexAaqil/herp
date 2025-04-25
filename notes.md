# Features
users {
    super admin
    admin
    teachers
    accountant
    store keeper
    librarian
    parents
    students
}

modules {
    dashboard
    users
    teachers + schedules(timetables)
    students
    payments
    expenses
    exams + grades
    inventory
    leaveouts
    leaves
    disciplinaries
    textbooks
    announcements
    messages
    classes + classrooms
    dorms
    subjects
    settings
}

reports {
    fees statement
    gate pass
    student performance report
    class performance report
    payment receipts after accountant makes payments
}

statistics {
    total staff members
    total teachers
    total students

    total fees paid
    expected fees
    total expenses
}

# DB DESIGN
users {
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('username')->unique()->nullable();
    $table->string('phone_number');
    $table->string('phone_other')->nullable();
    $table->unsignedTinyInteger('user_level')->default(2);
    $table->boolean('user_status')->default(true);
    $table->string('emp_code')->nullable();
    $table->date('emp_date')->nullable();
    $table->date('dob')->nullable();
    $table->char('gender', 1)->nullable();
    $table->string('image')->nullable();
    $table->string('address')->nullable();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
}

messages {
    $table->string('name');
    $table->string('email');
    $table->string('phone_number');
    $table->string('message', 2000);
    $table->boolean('status')->default(false);
    $table->timestamps();
}

classroom_categories {
    $table->string('name')->unique();
}

classrooms {
    $table->string('name')->unique();

    $table->foreignId('classroom_category_id')->constrained('classroom_categories')->cascadeOnDelete();
    $table->foreignId('class_teacher_id')->nullable()->constrained('users')->cascadeOnDelete();
}

dorms {
    $table->string('name')->unique();
}

subjects {
    $table->string('name', 100)->unique();
    $table->string('acronym', 10)->nullable();
    $table->string('code', 20)->nullable()->unique();
}

grades {
    $table->char('grade', 2)->unique();
    $table->unsignedTinyInteger('min_marks');
    $table->unsignedTinyInteger('max_marks');
}

teacher_subject_classroom {
    $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
    $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
}

guardians {
    $table->string('first_name');
    $table->string('last_name');
    $table->string('phone_number')->unique();
    $table->string('phone_other')->nullable();
    $table->string('email')->unique();
    $table->string('address')->nullable();
    $table->string('image')->nullable();
    $table->timestamps();
}

students {
    $table->string('adm_no')->unique()->nullable();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('dorm_room')->nullable();
    $table->date('year_admitted')->nullable();
    $table->unsignedTinyInteger('graduation_status')->default(0);
    $table->date('graduation_date')->nullable();
    $table->date('dob')->nullable();
    $table->string('gender')->nullable();
    $table->string('image')->nullable();
    $table->string('password');

    $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');
    $table->foreignId('dorm_id')->nullable()->constrained('dorms')->onDelete('set null');
    $table->timestamps();
}

guardian_student {
    $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
    $table->foreignId('guardian_id')->constrained('guardians')->cascadeOnDelete();

    $table->unique(['student_id', 'guardian_id']);
}

disciplinaries {
    $table->string('category');
    $table->text('comment');

    $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
}

leaveouts {
    $table->string('category');
    $table->text('comment');
    $table->date('from_date');
    $table->date('to_date');

    $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
}

leaves {
    $table->string('category');
    $table->text('comment');
    $table->date('from_date');
    $table->date('to_date');
    $table->boolean('status')->default(false);
    $table->string('response')->default('pending');

    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
}

textbooks {
    $table->string('book_name');
    $table->string('book_number');
    $table->date('date_issued')->nullable();
    $table->date('date_returned')->nullable();
    $table->string('status')->default('issued');

    $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
    $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
}

assignments {
    $table->date('date_issued');
    $table->date('deadline');
    $table->text('description');
    $table->string('uploaded_file');

    $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('classroom_id')->constrained('class_sections')->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
    $table->timestamps();
}

exams {
    $table->string('name');
    $table->unsignedSmallInteger('year');
    $table->unsignedTinyInteger('term');
}

exam_records {
    $table->unsignedTinyInteger('marks');
    $table->char('grade', 2)->nullable();
    $table->string('classroom');

    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
    $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
    $table->timestamps();
}

payments {
    $table->string('name', 100);
    $table->decimal('amount', 10, 2);
    $table->unsignedSmallInteger('year');
    $table->unsignedTinyInteger('term');

    $table->foreignId('classroom_category_id')->constrained('classroom_categories')->cascadeOnDelete();
    $table->timestamps();
}

payment_records {
    $table->decimal('amount_paid', 10, 2)->nullable();
    $table->decimal('balance', 10, 2)->nullable();

    $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
    $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
    $table->timestamps();
}

payment_receipts {
    $table->decimal('amount_paid', 10, 2);
    $table->string('payment_method')->default('cheque');
    $table->string('reference_number', 100)->unique()->nullable();
    $table->decimal('balance', 10, 2);
    $table->date('date_paid');

    $table->foreignId('payment_record_id')->constrained('payment_records')->cascadeOnDelete();
    $table->timestamps();
}

inventory_categories {
    $table->string('name')->unique();
}

inventory_items {
    $table->string('name')->unique();
    $table->string('unit');

    $table->foreignId('category_id')->constrained('inventory_categories')->cascadeOnDelete();
}

inventory_records {
    $table->string('type');
    $table->unsignedSmallInteger('quantity');
    $table->unsignedSmallInteger('remaining')->nullable();
    $table->string('description')->nullable();
    $table->date('date');

    $table->foreignId('item_id')->constrained('inventory_items')->cascadeOnDelete();
    $table->timestamps();
}

expense_categories {
    $table->string('name')->unique();
    $table->string('description')->nullable();
}

expense_recipients {
    $table->string('name');
    $table->string('email')->nullable();
    $table->string('phone_number')->unique();
    $table->string('company_name')->nullable();
}

expenses {
    $table->decimal('amount_paid', 10, 2);
    $table->string('payment_method');
    $table->string('reference_number')->nullable();
    $table->string('payment_status')->default('paid');
    $table->string('description', 255)->nullable();
    $table->date('date')->index();

    $table->foreignId('expense_category_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('expense_recipient_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
}

salaries {
    $table->decimal('salary', 10, 2);
    $table->decimal('amount_paid', 10, 2);
    $table->string('payment_method');
    $table->string('reference_number')->nullable();
    $table->string('payment_status')->default('paid');
    $table->string('description', 255)->nullable();
    $table->date('date')->index();

    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
}

settings {
    $table->string('school_name')->nullable();
    $table->string('school_acronym')->nullable();
    $table->string('school_address')->nullable();
    $table->string('school_phone_number')->nullable();
    $table->string('school_phone_other')->nullable();
    $table->string('school_email')->nullable();
    $table->unsignedSmallInteger('current_year')->nullable();
    $table->unsignedTinyInteger('current_term')->nullable();
    $table->date('term_begins')->nullable();
    $table->date('term_ends')->nullable();
    $table->string('bursar_stamp')->nullable();
    $table->string('principal_stamp')->nullable();
    $table->string('storekeeper_stamp')->nullable();
}

# Constants
// User
const USERLEVELS = [
    0 => 'super admin',
    1 => 'admin',
    2 => 'teacher',
    3 => 'accountant',
    4 => 'store keeper',
    5 => 'librarian',
    6 => 'bom',
];

// Student
const GRADUATION_STATUS = [
    0 => 'not graduated',
    1 => 'graduated',
    2 => 'transfered',
];

// Leaveouts
const LEAVEOUTSCATEGORIES = [
    'casual',
    'emergency',
    'sick',
];

// Leaves
const LEAVESCATEGORIES = [
    'casual',
    'sick',
    'study',
    'maternal',
];

// Textbooks
const STATUSES = [
    'issued',
    'returned',
    'lost',
];


# User Journeys
## Super Admin
- Can RUD messages from users through the contact form.

- Can update the school's settings like the name, logo and stamps.
- Can CRUD classrooms.
- Can CRUD dorms.
- Can CRUD subjects.
- Can CRUD grades.

- Can CRUD users and their user levels including super admins.

- Can CRUD recipients of payments made from the school as expenses.
- Can CRUD payments made from the school as expenses.
- Can CRUD payments made by students to the school.
- Can CRUD inventory categories and records for items going in and out of the store.

- Can CRUD leavouts issued to students.
- Can CRUD disciplinaries issued to students.
- Can CRUD exams and exam records for students.
- Can CRUD assignments issued to students or download.
- Can CRUD textbooks issued to students.

- Can CRUD teachers schedules (timetable).

- Can CRUD leave requests from the staff.



## Admin
- Can RUD messages from users through the contact form.

- Can CRUD classrooms.
- Can CRUD dorms.
- Can CRUD subjects.
- Can CRUD grades.

- Can RU user details except the user levels.

- Can CRUD recipients of payments made from the school as expenses.
- Can CRUD payments made from the school as expenses.
- Can CRUD payments made by students to the school.

- Can CRUD inventory categories and records for items going in and out of the store.

- Can CRUD leavouts issued to students.
- Can CRUD disciplinaries issued to students.
- Can CRUD exams and exam records for students.
- Can CRUD assignments issued to students or download.
- Can CRUD textbooks issued to students.

- Can CRUD teachers schedules (timetable).

- Can CRUD leave requests from the staff.



## Accountant
- Can CRUD recipients of payments made from the school as expenses.
- Can CRUD payments made from the school as expenses.
- Can CRUD payments made by students to the school.

- Can R inventory records for items going in and out of the store.

- Can apply for leaves.



## Store Keeper
- Can CRUD inventory records for items going in and out of the store.

- Can apply for leaves.



## Teacher
- Can R their schedule (timetable).

- Can CRUD assignments that can be downloaded by students.

- Can CRUD leaveouts they have issued to students.
- Can R other leaveouts issued by other teachers.

- Can apply for leaves.



## BOM
- Can R user details.

- Can CRUD leave requests from the staff.

- Can R teachers schedule (timetable).

- Can manually generate a gate pass for a student.
- Can R expenses.
- Can R payments made by students.




## Student
- Can R their details.

- Can R their exam records.
- Can R their disciplinary records.
- Can R leaveouts issued to them.
- Can R textbooks issued to them.

- Can download the assignments issued by teachers.


## Parent
- Can R their details.

- Can R their exam records.
- Can R their disciplinary records.
- Can R leaveouts issued to them.
- Can R textbooks issued to them.

- Can download the assignments issued by teachers.

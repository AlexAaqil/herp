# TODOs:
App
- Implement pagination.

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
    $table->foreignId('class_teacher_id')->nullable()->constrained('users)->cascadeOnDelete();
}

dorms {
    $table->string('name')->unique();
}

grades {
    $table->char('grade', 2)->unique();
    $table->unsignedTinyInteger('min_marks');
    $table->unsignedTinyInteger('max_marks');
}

subjects {
    $table->string('name', 100)->unique();
    $table->string('acronym', 10)->nullable();
    $table->string('code', 20)->nullable()->unique();
}

classroom_subject_teacher {
    $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
    $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
}

parents {
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

parent_student {
    $table->unsignedBigInteger('student_id');
    $table->unsignedBigInteger('parent_id');

    $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');

    $table->unique(['student_id', 'parent_id']);
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
    $table->text('reason');
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
    $table->enum('status', ['issued', 'returned', 'lost'])->default('issued');

    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
}

payments {
    $table->string('name', 100);
    $table->decimal('amount', 10, 2);
    $table->unsignedSmallInteger('year');
    $table->unsignedTinyInteger('term');

    $table->foreignId('classroom_category_id')->constrained('classroom_categories')->onDelete('cascade');
    $table->timestamps();
}

payment_records {
    $table->string('reference_number', 100)->unique()->nullable();
    $table->string('payment_method')->default('cheque');
    $table->decimal('amount_paid', 10, 2)->nullable();
    $table->decimal('balance', 10, 2)->nullable();

    $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
    $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
    $table->timestamps();
}

payment_receipts {
    $table->decimal('amount_paid', 10, 2);
    $table->decimal('balance', 10, 2);
    $table->date('date_paid');

    $table->foreignId('payment_record_id')->constrained('payment_records')->onDelete('cascade');
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

    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
    $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
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

expenses {
    $table->string('category')->index();
    $table->string('recepient', 255);
    $table->decimal('amount_paid', 10, 2);
    $table->date('date')->index();
    $table->string('description', 255)->nullable();
    $table->timestamps();
}

assignments {
    $table->date('date_issued');
    $table->date('deadline');
    $table->text('description');
    $table->string('assignment_path');

    $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('class_section_id')->constrained('class_sections')->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
    $table->timestamps();
}

settings {
    $table->string('school_name');
    $table->string('school_acronym');
    $table->string('school_address');
    $table->string('school_phone_number');
    $table->string('school_phone_other');
    $table->string('school_email');
    $table->unsignedSmallInteger('current_year')->nullable();
    $table->unsignedTinyInteger('current_term')->nullable();
    $table->date('term_begins')->nullable();
    $table->date('term_ends')->nullable();
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
];

// Student
const GRADUATION_STATUS = [
    0 => 'not graduated',
    1 => 'graduated',
    2 => 'transfered',
];

// Disciplinaries
const DISCIPLINARYCATEGORIES = [
    'minor',
    'major',
];

// Leaveouts
const LEAVEOUTSCATEGORIES = [
    'casual',
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
const TEXTBOOKSTATUS = [
    'issued',
    'returned',
    'lost',
];

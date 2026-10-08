<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student edit page can be rendered', function () {
    $student = Student::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'date_of_birth' => '2000-01-01',
    ]);

    $response = $this->get("/students/{$student->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('student.edit');
    $response->assertViewHas('student', $student);
    $response->assertSee('John Doe');
});

test('student edit page returns 404 if student does not exist', function () {
    $response = $this->get('/students/999/edit');

    $response->assertStatus(404);
});

test('student list contains edit link for each student', function () {
    $student = Student::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '0987654321',
    ]);

    $response = $this->get('/students');

    $response->assertStatus(200);
    $response->assertSee("/students/{$student->id}/edit");
});

<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Resignation;
use App\Models\User;
use App\Notifications\ResignationApplicationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResignationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_resignation_application_sends_notification_to_hr_and_admin()
    {
        // Mock notifications
        Notification::fake();

        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create HR user
        $hrUser = User::factory()->create([
            'role_users_id' => 6, // HR role
            'email' => 'hr@test.com',
            'first_name' => 'HR',
            'last_name' => 'User'
        ]);

        // Create Admin user
        $adminUser = User::factory()->create([
            'role_users_id' => 1, // Admin role
            'email' => 'admin@test.com',
            'first_name' => 'Admin',
            'last_name' => 'User'
        ]);

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create employee user
        $employeeUser = User::factory()->create([
            'role_users_id' => 2, // Employee role
            'email' => 'employee@test.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        // Login as employee
        $this->actingAs($employeeUser);

        // Prepare resignation data
        $resignationData = [
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'description' => 'Personal reasons',
            'resignation_date' => '2024-12-31',
            'notice_date' => '2024-12-01'
        ];

        // Submit resignation
        $response = $this->post('/core_hr/resignations', $resignationData);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Data Added successfully.']);

        // Assert notifications were sent
        Notification::assertSentTo(
            [$hrUser, $adminUser],
            ResignationApplicationNotification::class
        );

        // Assert resignation was created
        $this->assertDatabaseHas('resignations', [
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'description' => 'Personal reasons'
        ]);
    }

    public function test_resignation_notification_contains_correct_data()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        $hrUser = User::factory()->create([
            'role_users_id' => 6,
            'email' => 'hr@test.com'
        ]);

        // Create notification
        $notification = new ResignationApplicationNotification(
            'John Doe',
            '2024-12-31',
            '2024-12-01',
            'Personal reasons',
            'Test Company',
            'Test Department'
        );

        // Test mail content
        $mailMessage = $notification->toMail($hrUser);
        
        $this->assertStringContainsString('New Resignation Application - John Doe', $mailMessage->subject);
        $this->assertStringContainsString('John Doe', $mailMessage->introLines[2]);
        $this->assertStringContainsString('Test Company', $mailMessage->introLines[3]);
        $this->assertStringContainsString('Test Department', $mailMessage->introLines[4]);
        $this->assertStringContainsString('2024-12-31', $mailMessage->introLines[5]);
        $this->assertStringContainsString('2024-12-01', $mailMessage->introLines[6]);
        $this->assertStringContainsString('Personal reasons', $mailMessage->introLines[7]);

        // Test array content
        $arrayData = $notification->toArray($hrUser);
        $this->assertEquals('John Doe has submitted a resignation application.', $arrayData['data']);
        $this->assertEquals('/core_hr/resignations', $arrayData['link']);
        $this->assertEquals('John Doe', $arrayData['employee_name']);
    }
}



















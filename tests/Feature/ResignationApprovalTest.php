<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Resignation;
use App\Models\User;
use App\Notifications\ResignationApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResignationApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_hr_can_approve_resignation()
    {
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

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending',
            'hr_approved' => false,
            'admin_approved' => false
        ]);

        // Login as HR
        $this->actingAs($hrUser);

        // Approve resignation
        $response = $this->post("/core_hr/resignations/{$resignation->id}/hr-approve", [
            'notes' => 'HR approval notes'
        ]);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Resignation approved by HR successfully']);

        // Assert resignation is updated
        $resignation->refresh();
        $this->assertTrue($resignation->hr_approved);
        $this->assertEquals($hrUser->id, $resignation->hr_approved_by);
        $this->assertEquals('HR approval notes', $resignation->hr_approval_notes);
        $this->assertNotNull($resignation->hr_approved_at);
    }

    public function test_admin_can_approve_resignation()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
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

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending',
            'hr_approved' => false,
            'admin_approved' => false
        ]);

        // Login as Admin
        $this->actingAs($adminUser);

        // Approve resignation
        $response = $this->post("/core_hr/resignations/{$resignation->id}/admin-approve", [
            'notes' => 'Admin approval notes'
        ]);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Resignation approved by Admin successfully']);

        // Assert resignation is updated
        $resignation->refresh();
        $this->assertTrue($resignation->admin_approved);
        $this->assertEquals($adminUser->id, $resignation->admin_approved_by);
        $this->assertEquals('Admin approval notes', $resignation->admin_approval_notes);
        $this->assertNotNull($resignation->admin_approved_at);
    }

    public function test_resignation_fully_approved_when_both_hr_and_admin_approve()
    {
        // Mock notifications
        Notification::fake();

        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create HR and Admin users
        $hrUser = User::factory()->create([
            'role_users_id' => 6,
            'email' => 'hr@test.com'
        ]);

        $adminUser = User::factory()->create([
            'role_users_id' => 1,
            'email' => 'admin@test.com'
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
            'role_users_id' => 2,
            'email' => 'employee@test.com'
        ]);

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending',
            'hr_approved' => false,
            'admin_approved' => false
        ]);

        // First, HR approves
        $this->actingAs($hrUser);
        $response = $this->post("/core_hr/resignations/{$resignation->id}/hr-approve");
        $response->assertStatus(200);

        // Then, Admin approves
        $this->actingAs($adminUser);
        $response = $this->post("/core_hr/resignations/{$resignation->id}/admin-approve");
        $response->assertStatus(200);

        // Assert resignation is fully approved
        $resignation->refresh();
        $this->assertTrue($resignation->hr_approved);
        $this->assertTrue($resignation->admin_approved);
        $this->assertEquals('approved', $resignation->status);
        $this->assertTrue($resignation->isFullyApproved());

        // Assert notification was sent to employee
        Notification::assertSentTo(
            $employeeUser,
            ResignationApprovedNotification::class
        );
    }

    public function test_hr_can_reject_resignation()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create HR user
        $hrUser = User::factory()->create([
            'role_users_id' => 6,
            'email' => 'hr@test.com'
        ]);

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending'
        ]);

        // Login as HR
        $this->actingAs($hrUser);

        // Reject resignation
        $response = $this->post("/core_hr/resignations/{$resignation->id}/hr-reject", [
            'notes' => 'HR rejection reason'
        ]);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Resignation rejected by HR successfully']);

        // Assert resignation is rejected
        $resignation->refresh();
        $this->assertEquals('rejected', $resignation->status);
        $this->assertFalse($resignation->hr_approved);
        $this->assertEquals('HR rejection reason', $resignation->hr_approval_notes);
    }

    public function test_admin_can_reject_resignation()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create Admin user
        $adminUser = User::factory()->create([
            'role_users_id' => 1,
            'email' => 'admin@test.com'
        ]);

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending'
        ]);

        // Login as Admin
        $this->actingAs($adminUser);

        // Reject resignation
        $response = $this->post("/core_hr/resignations/{$resignation->id}/admin-reject", [
            'notes' => 'Admin rejection reason'
        ]);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['success' => 'Resignation rejected by Admin successfully']);

        // Assert resignation is rejected
        $resignation->refresh();
        $this->assertEquals('rejected', $resignation->status);
        $this->assertFalse($resignation->admin_approved);
        $this->assertEquals('Admin rejection reason', $resignation->admin_approval_notes);
    }

    public function test_employee_cannot_approve_resignation()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create employee user
        $employeeUser = User::factory()->create([
            'role_users_id' => 2, // Employee role
            'email' => 'employee@test.com'
        ]);

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create resignation
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending'
        ]);

        // Login as employee
        $this->actingAs($employeeUser);

        // Try to approve resignation
        $response = $this->post("/core_hr/resignations/{$resignation->id}/hr-approve");

        // Assert access denied
        $response->assertStatus(403);
        $response->assertJson(['error' => 'Only HR can approve resignations']);
    }

    public function test_cannot_approve_already_approved_resignation()
    {
        // Create test data
        $company = Company::factory()->create(['company_name' => 'Test Company']);
        $department = Department::factory()->create(['department_name' => 'Test Department']);
        
        // Create HR user
        $hrUser = User::factory()->create([
            'role_users_id' => 6,
            'email' => 'hr@test.com'
        ]);

        // Create employee
        $employee = Employee::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);

        // Create resignation already approved by HR
        $resignation = Resignation::factory()->create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'status' => 'pending',
            'hr_approved' => true,
            'hr_approved_by' => $hrUser->id
        ]);

        // Login as HR
        $this->actingAs($hrUser);

        // Try to approve again
        $response = $this->post("/core_hr/resignations/{$resignation->id}/hr-approve");

        // Assert error
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Resignation already approved by HR']);
    }
}



















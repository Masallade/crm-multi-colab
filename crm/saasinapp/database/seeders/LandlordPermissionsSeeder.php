<?php

namespace Database\Seeders;

use App\Http\traits\PermissionHandleTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandlordPermissionsSeeder extends Seeder
{
    use PermissionHandleTrait;
    // php artisan db:seed --class=LandlordPermissionsSeeder

    public function run()
    {
		DB::table('permissions')->delete();
        
        $permissions = $this->getAllPermissions();

        DB::table('permissions')->insert($permissions);
    }




    // public function run()
    // {
	// 	DB::table('permissions')->delete();

    //     $treeview1 = $this->treeview1();
    //     $treeview2 = $this->treeview2();
    //     $treeview3 = $this->treeview3();
    //     $customize = $this->customize();

    //     $permissions = array_merge($treeview1, $treeview2, $treeview3, $customize);

    //     DB::table('permissions')->insert($permissions);
    // }




    // private function treeview1() : array
    // {
    //     return array(
    //         array(
	// 			'id' => 1,
	// 			'guard_name' => 'web',
	// 			'name' => 'user',
    //             'parent'=> null,
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 2,
	// 			'guard_name' => 'web',
	// 			'name' => 'view-user',
    //             'parent'=> 'user',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 3,
	// 			'guard_name' => 'web',
	// 			'name' => 'edit-user',
    //             'parent'=> 'user',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 4,
	// 			'guard_name' => 'web',
	// 			'name' => 'delete-user',
    //             'parent'=> 'user',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 5,
	// 			'guard_name' => 'web',
	// 			'name' => 'details-employee',
    //             'parent'=> null,
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 6,
	// 			'guard_name' => 'web',
	// 			'name' => 'view-details-employee',
    //             'parent'=> 'details-employee',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 7,
	// 			'guard_name' => 'web',
	// 			'name' => 'store-details-employee',
    //             'parent'=> 'details-employee',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 8,
	// 			'guard_name' => 'web',
	// 			'name' => 'modify-details-employee',
    //             'parent'=> 'details-employee',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 9,
	// 			'guard_name' => 'web',
	// 			'name' => 'import-employee',
    //             'parent'=> 'details-employee',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 10,
	// 			'guard_name' => 'web',
	// 			'name' => 'customize-setting',
    //             'parent'=> null,
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 11,
	// 			'guard_name' => 'web',
	// 			'name' => 'role',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 12,
	// 			'guard_name' => 'web',
	// 			'name' => 'view-role',
    //             'parent'=> 'role',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 13,
	// 			'guard_name' => 'web',
	// 			'name' => 'store-role',
    //             'parent'=> 'role',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 14,
	// 			'guard_name' => 'web',
	// 			'name' => 'edit-role',
    //             'parent'=> 'role',
    //             'treeview'=> 1
	// 		),
	// 		array(
	// 			'id' => 15,
	// 			'guard_name' => 'web',
	// 			'name' => 'delete-role',
    //             'parent'=> 'role',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 16,
	// 			'guard_name' => 'web',
	// 			'name' => 'set-permission',
    //             'parent'=> 'role',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 17,
	// 			'guard_name' => 'web',
	// 			'name' => 'general-setting',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 18,
	// 			'guard_name' => 'web',
	// 			'name' => 'view-general-setting',
    //             'parent'=> 'general-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 19,
	// 			'guard_name' => 'web',
	// 			'name' => 'store-general-setting',
    //             'parent'=> 'general-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 20,
	// 			'guard_name' => 'web',
	// 			'name' => 'mail-setting',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 21,
	// 			'guard_name' => 'web',
	// 			'name' => 'view-mail-setting',
    //             'parent'=> 'mail-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 22,
	// 			'guard_name' => 'web',
	// 			'name' => 'store-mail-setting',
    //             'parent'=> 'mail-setting',
    //             'treeview'=> 1
	// 		),

    //         array(
	// 			'id' => 23,
	// 			'guard_name' => 'web',
	// 			'name' => 'access-variable_type',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 24,
	// 			'guard_name' => 'web',
	// 			'name' => 'access-variable_method',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),
    //         array(
	// 			'id' => 25,
	// 			'guard_name' => 'web',
	// 			'name' => 'access-language',
    //             'parent'=> 'customize-setting',
    //             'treeview'=> 1
	// 		),

    //         // Company
    //         array(
    //             'id' => 26,
    //             'guard_name' => 'web',
    //             'name' => 'company',
    //             'parent' => null,
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 27,
    //             'guard_name' => 'web',
    //             'name' => 'view-company',
    //             'parent' => 'company',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 28,
    //             'guard_name' => 'web',
    //             'name' => 'store-company',
    //             'parent' => 'company',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 29,
    //             'guard_name' => 'web',
    //             'name' => 'edit-company',
    //             'parent' => 'company',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 30,
    //             'guard_name' => 'web',
    //             'name' => 'delete-company',
    //             'parent' => 'company',
    //             'treeview' => 1
    //         ),

    //         // Department

    //         array(
    //             'id' => 31,
    //             'guard_name' => 'web',
    //             'name' => 'department',
    //             'parent' => null,
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 32,
    //             'guard_name' => 'web',
    //             'name' => 'view-department',
    //             'parent' => 'department',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 33,
    //             'guard_name' => 'web',
    //             'name' => 'store-department',
    //             'parent' => 'department',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 34,
    //             'guard_name' => 'web',
    //             'name' => 'edit-department',
    //             'parent' => 'department',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 35,
    //             'guard_name' => 'web',
    //             'name' => 'delete-department',
    //             'parent' => 'department',
    //             'treeview' => 1
    //         ),

    //         // Designation

    //         array(
    //             'id' => 36,
    //             'guard_name' => 'web',
    //             'name' => 'designation',
    //             'parent' => null,
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 37,
    //             'guard_name' => 'web',
    //             'name' => 'view-designation',
    //             'parent' => 'designation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 38,
    //             'guard_name' => 'web',
    //             'name' => 'store-designation',
    //             'parent' => 'designation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 39,
    //             'guard_name' => 'web',
    //             'name' => 'edit-designation',
    //             'parent' => 'designation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 40,
    //             'guard_name' => 'web',
    //             'name' => 'delete-designation',
    //             'parent' => 'designation',
    //             'treeview' => 1
    //         ),

    //         // Location
    //         array(
    //             'id' => 41,
    //             'guard_name' => 'web',
    //             'name' => 'location',
    //             'parent' => null,
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 42,
    //             'guard_name' => 'web',
    //             'name' => 'view-location',
    //             'parent' => 'location',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 43,
    //             'guard_name' => 'web',
    //             'name' => 'store-location',
    //             'parent' => 'location',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 44,
    //             'guard_name' => 'web',
    //             'name' => 'edit-location',
    //             'parent' => 'location',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 45,
    //             'guard_name' => 'web',
    //             'name' => 'delete-location',
    //             'parent' => 'location',
    //             'treeview' => 1
    //         ),

    //         // Core HR
    //         array(
    //             'id' => 46,
    //             'guard_name' => 'web',
    //             'name' => 'core_hr',
    //             'parent' => null,
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 47,
    //             'guard_name' => 'web',
    //             'name' => 'view-calendar',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),

    //         // Promotion
    //         array(
    //             'id' => 48,
    //             'guard_name' => 'web',
    //             'name' => 'promotion',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 49,
    //             'guard_name' => 'web',
    //             'name' => 'view-promotion',
    //             'parent' => 'promotion',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 50,
    //             'guard_name' => 'web',
    //             'name' => 'store-promotion',
    //             'parent' => 'promotion',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 51,
    //             'guard_name' => 'web',
    //             'name' => 'edit-promotion',
    //             'parent' => 'promotion',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 52,
    //             'guard_name' => 'web',
    //             'name' => 'delete-promotion',
    //             'parent' => 'promotion',
    //             'treeview' => 1
    //         ),

    //         // Award
    //         array(
    //             'id' => 53,
    //             'guard_name' => 'web',
    //             'name' => 'award',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 54,
    //             'guard_name' => 'web',
    //             'name' => 'view-award',
    //             'parent' => 'award',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 55,
    //             'guard_name' => 'web',
    //             'name' => 'store-award',
    //             'parent' => 'award',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 56,
    //             'guard_name' => 'web',
    //             'name' => 'edit-award',
    //             'parent' => 'award',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 57,
    //             'guard_name' => 'web',
    //             'name' => 'delete-award',
    //             'parent' => 'award',
    //             'treeview' => 1
    //         ),

    //         // Transfer
    //         array(
    //             'id' => 58,
    //             'guard_name' => 'web',
    //             'name' => 'transfer',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 59,
    //             'guard_name' => 'web',
    //             'name' => 'view-transfer',
    //             'parent' => 'transfer',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 60,
    //             'guard_name' => 'web',
    //             'name' => 'store-transfer',
    //             'parent' => 'transfer',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 61,
    //             'guard_name' => 'web',
    //             'name' => 'edit-transfer',
    //             'parent' => 'transfer',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 62,
    //             'guard_name' => 'web',
    //             'name' => 'delete-transfer',
    //             'parent' => 'transfer',
    //             'treeview' => 1
    //         ),

    //         // Travel
    //         array(
    //             'id' => 63,
    //             'guard_name' => 'web',
    //             'name' => 'travel',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 64,
    //             'guard_name' => 'web',
    //             'name' => 'view-travel',
    //             'parent' => 'travel',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 65,
    //             'guard_name' => 'web',
    //             'name' => 'store-travel',
    //             'parent' => 'travel',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 66,
    //             'guard_name' => 'web',
    //             'name' => 'edit-travel',
    //             'parent' => 'travel',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 67,
    //             'guard_name' => 'web',
    //             'name' => 'delete-travel',
    //             'parent' => 'travel',
    //             'treeview' => 1
    //         ),

    //         // Resignation
    //         array(
    //             'id' => 68,
    //             'guard_name' => 'web',
    //             'name' => 'resignation',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 69,
    //             'guard_name' => 'web',
    //             'name' => 'view-resignation',
    //             'parent' => 'resignation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 70,
    //             'guard_name' => 'web',
    //             'name' => 'store-resignation',
    //             'parent' => 'resignation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 71,
    //             'guard_name' => 'web',
    //             'name' => 'edit-resignation',
    //             'parent' => 'resignation',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 72,
    //             'guard_name' => 'web',
    //             'name' => 'delete-resignation',
    //             'parent' => 'resignation',
    //             'treeview' => 1
    //         ),
    //         // Complaint
    //         array(
    //             'id' => 73,
    //             'guard_name' => 'web',
    //             'name' => 'complaint',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 74,
    //             'guard_name' => 'web',
    //             'name' => 'view-complaint',
    //             'parent' => 'complaint',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 75,
    //             'guard_name' => 'web',
    //             'name' => 'store-complaint',
    //             'parent' => 'complaint',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 76,
    //             'guard_name' => 'web',
    //             'name' => 'edit-complaint',
    //             'parent' => 'complaint',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 77,
    //             'guard_name' => 'web',
    //             'name' => 'delete-complaint',
    //             'parent' => 'complaint',
    //             'treeview' => 1
    //         ),

    //         // Warning
    //         array(
    //             'id' => 78,
    //             'guard_name' => 'web',
    //             'name' => 'warning',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 79,
    //             'guard_name' => 'web',
    //             'name' => 'view-warning',
    //             'parent' => 'warning',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 80,
    //             'guard_name' => 'web',
    //             'name' => 'store-warning',
    //             'parent' => 'warning',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 81,
    //             'guard_name' => 'web',
    //             'name' => 'edit-warning',
    //             'parent' => 'warning',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 82,
    //             'guard_name' => 'web',
    //             'name' => 'delete-warning',
    //             'parent' => 'warning',
    //             'treeview' => 1
    //         ),

    //         // Termination
    //         array(
    //             'id' => 83,
    //             'guard_name' => 'web',
    //             'name' => 'termination',
    //             'parent' => 'core_hr',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 84,
    //             'guard_name' => 'web',
    //             'name' => 'view-termination',
    //             'parent' => 'termination',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 85,
    //             'guard_name' => 'web',
    //             'name' => 'store-termination',
    //             'parent' => 'termination',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 86,
    //             'guard_name' => 'web',
    //             'name' => 'edit-termination',
    //             'parent' => 'termination',
    //             'treeview' => 1
    //         ),
    //         array(
    //             'id' => 87,
    //             'guard_name' => 'web',
    //             'name' => 'delete-termination',
    //             'parent' => 'termination',
    //             'treeview' => 1
    //         ),
    //     );
    // }

    // private function treeview2() : array
    // {
    //     return [
    //         array(
    //             'id' => 88,
    //             'guard_name' => 'web',
    //             'name' => 'timesheet',
    //             'parent'=> null,
    //             'treeview'=> 2
    //         ),

    //         // Attendance
    //         array(
    //             'id' => 89,
    //             'guard_name' => 'web',
    //             'name' => 'attendance',
    //             'parent'=> 'timesheet',
    //             'treeview'=> 2
    //         ),
    //         array(
    //             'id' => 90,
    //             'guard_name' => 'web',
    //             'name' => 'view-attendance',
    //             'parent' => 'attendance',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 91,
    //             'guard_name' => 'web',
    //             'name' => 'edit-attendance',
    //             'parent' => 'attendance',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 92,
    //             'guard_name' => 'web',
    //             'name' => 'delete-attendance',
    //             'parent' => 'attendance',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 93,
    //             'guard_name' => 'web',
    //             'name' => 'import-attendance',
    //             'parent' => 'attendance',
    //             'treeview' => 2
    //         ),

    //         // office_shift
    //         array(
    //             'id' => 94,
    //             'guard_name' => 'web',
    //             'name' => 'office_shift',
    //             'parent' => 'timesheet',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 95,
    //             'guard_name' => 'web',
    //             'name' => 'view-office_shift',
    //             'parent' => 'office_shift',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 96,
    //             'guard_name' => 'web',
    //             'name' => 'store-office_shift',
    //             'parent' => 'office_shift',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 97,
    //             'guard_name' => 'web',
    //             'name' => 'edit-office_shift',
    //             'parent' => 'office_shift',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 98,
    //             'guard_name' => 'web',
    //             'name' => 'delete-office_shift',
    //             'parent' => 'office_shift',
    //             'treeview' => 2
    //         ),

    //         // holiday
    //         array(
    //             'id' => 99,
    //             'guard_name' => 'web',
    //             'name' => 'holiday',
    //             'parent' => 'timesheet',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 100,
    //             'guard_name' => 'web',
    //             'name' => 'view-holiday',
    //             'parent' => 'holiday',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 101,
    //             'guard_name' => 'web',
    //             'name' => 'store-holiday',
    //             'parent' => 'holiday',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 102,
    //             'guard_name' => 'web',
    //             'name' => 'edit-holiday',
    //             'parent' => 'holiday',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 103,
    //             'guard_name' => 'web',
    //             'name' => 'delete-holiday',
    //             'parent' => 'holiday',
    //             'treeview' => 2
    //         ),

    //         // leave
    //         array(
    //             'id' => 104,
    //             'guard_name' => 'web',
    //             'name' => 'leave',
    //             'parent'=> 'timesheet',
    //             'treeview'=> 2
    //         ),
    //         array(
    //             'id' => 105,
    //             'guard_name' => 'web',
    //             'name' => 'view-leave',
    //             'parent' => 'leave',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 106,
    //             'guard_name' => 'web',
    //             'name' => 'store-leave',
    //             'parent' => 'leave',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 107,
    //             'guard_name' => 'web',
    //             'name' => 'edit-leave',
    //             'parent' => 'leave',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 108,
    //             'guard_name' => 'web',
    //             'name' => 'delete-leave',
    //             'parent' => 'leave',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 109,
    //             'guard_name' => 'web',
    //             'name' => 'get-leave-notification',
    //             'parent' => 'leave',
    //             'treeview' => 2
    //         ),

    //         // payment-module
    //         array(
    //             'id' => 110,
    //             'guard_name' => 'web',
    //             'name' => 'payment-module',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 111,
    //             'guard_name' => 'web',
    //             'name' => 'view-payslip',
    //             'parent' => 'payment-module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 112,
    //             'guard_name' => 'web',
    //             'name' => 'make-payment',
    //             'parent' => 'payment-module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 113,
    //             'guard_name' => 'web',
    //             'name' => 'make-bulk_payment',
    //             'parent' => 'payment-module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 114,
    //             'guard_name' => 'web',
    //             'name' => 'view-paylist',
    //             'parent' => 'payment-module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 115,
    //             'guard_name' => 'web',
    //             'name' => 'set-salary',
    //             'parent' => 'payment-module',
    //             'treeview' => 2
    //         ),

    //         // hr_report
    //         array(
    //             'id' => 116,
    //             'guard_name' => 'web',
    //             'name' => 'hr_report',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 117,
    //             'guard_name' => 'web',
    //             'name' => 'daily-attendances',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 118,
    //             'guard_name' => 'web',
    //             'name' => 'date-wise-attendances',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 119,
    //             'guard_name' => 'web',
    //             'name' => 'monthly-attendances',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 120,
    //             'guard_name' => 'web',
    //             'name' => 'report-training',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 121,
    //             'guard_name' => 'web',
    //             'name' => 'report-project',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 122,
    //             'guard_name' => 'web',
    //             'name' => 'report-task',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 123,
    //             'guard_name' => 'web',
    //             'name' => 'report-employee',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 124,
    //             'guard_name' => 'web',
    //             'name' => 'report-account',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 125,
    //             'guard_name' => 'web',
    //             'name' => 'report-deposit',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 126,
    //             'guard_name' => 'web',
    //             'name' => 'report-expense',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 127,
    //             'guard_name' => 'web',
    //             'name' => 'report-transaction',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 128,
    //             'guard_name' => 'web',
    //             'name' => 'report-pension',
    //             'parent' => 'hr_report',
    //             'treeview' => 2
    //         ),

    //         // recruitment
    //         array(
    //             'id' => 129,
    //             'guard_name' => 'web',
    //             'name' => 'recruitment',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),

    //         // job_post
    //         array(
    //             'id' => 130,
    //             'guard_name' => 'web',
    //             'name' => 'job_post',
    //             'parent' => 'recruitment',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 131,
    //             'guard_name' => 'web',
    //             'name' => 'view-job_post',
    //             'parent' => 'job_post',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 132,
    //             'guard_name' => 'web',
    //             'name' => 'store-job_post',
    //             'parent' => 'job_post',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 133,
    //             'guard_name' => 'web',
    //             'name' => 'edit-job_post',
    //             'parent' => 'job_post',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 134,
    //             'guard_name' => 'web',
    //             'name' => 'delete-job_post',
    //             'parent' => 'job_post',
    //             'treeview' => 2
    //         ),

    //         // job_candidate
    //         array(
    //             'id' => 135,
    //             'guard_name' => 'web',
    //             'name' => 'job_candidate',
    //             'parent' => 'recruitment',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 136,
    //             'guard_name' => 'web',
    //             'name' => 'view-job_candidate',
    //             'parent' => 'job_candidate',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 137,
    //             'guard_name' => 'web',
    //             'name' => 'delete-job_candidate',
    //             'parent' => 'job_candidate',
    //             'treeview' => 2
    //         ),

    //         // job_interview
    //         array(
    //             'id' => 138,
    //             'guard_name' => 'web',
    //             'name' => 'job_interview',
    //             'parent' => 'recruitment',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 139,
    //             'guard_name' => 'web',
    //             'name' => 'view-job_interview',
    //             'parent' => 'job_interview',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 140,
    //             'guard_name' => 'web',
    //             'name' => 'edit-job_interview',
    //             'parent' => 'job_interview',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 141,
    //             'guard_name' => 'web',
    //             'name' => 'delete-job_interview',
    //             'parent' => 'job_interview',
    //             'treeview' => 2
    //         ),

    //         // CMS
    //         array(
    //             'id' => 142,
    //             'guard_name' => 'web',
    //             'name' => 'cms',
    //             'parent' => 'recruitment',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 143,
    //             'guard_name' => 'web',
    //             'name' => 'view-cms',
    //             'parent' => 'cms',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 144,
    //             'guard_name' => 'web',
    //             'name' => 'store-cms',
    //             'parent' => 'cms',
    //             'treeview' => 2
    //         ),

    //         // project-management
    //         array(
    //             'id' => 145,
    //             'guard_name' => 'web',
    //             'name' => 'project-management',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),

    //         // Project
    //         array(
    //             'id' => 146,
    //             'guard_name' => 'web',
    //             'name' => 'project',
    //             'parent' => 'project-management',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 147,
    //             'guard_name' => 'web',
    //             'name' => 'view-project',
    //             'parent' => 'project',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 148,
    //             'guard_name' => 'web',
    //             'name' => 'store-project',
    //             'parent' => 'project',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 149,
    //             'guard_name' => 'web',
    //             'name' => 'edit-project',
    //             'parent' => 'project',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 150,
    //             'guard_name' => 'web',
    //             'name' => 'delete-project',
    //             'parent' => 'project',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 151,
    //             'guard_name' => 'web',
    //             'name' => 'assign-project',
    //             'parent' => 'project',
    //             'treeview' => 2
    //         ),

    //         // Task
    //         array(
    //             'id' => 152,
    //             'guard_name' => 'web',
    //             'name' => 'task',
    //             'parent' => 'project-management',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 153,
    //             'guard_name' => 'web',
    //             'name' => 'view-task',
    //             'parent' => 'task',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 154,
    //             'guard_name' => 'web',
    //             'name' => 'store-task',
    //             'parent' => 'task',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 155,
    //             'guard_name' => 'web',
    //             'name' => 'edit-task',
    //             'parent' => 'task',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 156,
    //             'guard_name' => 'web',
    //             'name' => 'delete-task',
    //             'parent' => 'task',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 157,
    //             'guard_name' => 'web',
    //             'name' => 'assign-task',
    //             'parent' => 'task',
    //             'treeview' => 2
    //         ),

    //         // client
    //         array(
    //             'id' => 158,
    //             'guard_name' => 'web',
    //             'name' => 'client',
    //             'parent' => 'project-management',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 159,
    //             'guard_name' => 'web',
    //             'name' => 'view-client',
    //             'parent' => 'client',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 160,
    //             'guard_name' => 'web',
    //             'name' => 'store-client',
    //             'parent' => 'client',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 161,
    //             'guard_name' => 'web',
    //             'name' => 'edit-client',
    //             'parent' => 'client',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 162,
    //             'guard_name' => 'web',
    //             'name' => 'delete-client',
    //             'parent' => 'client',
    //             'treeview' => 2
    //         ),

    //         // invoice
    //         array(
    //             'id' => 163,
    //             'guard_name' => 'web',
    //             'name' => 'invoice',
    //             'parent' => 'project-management',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 164,
    //             'guard_name' => 'web',
    //             'name' => 'view-invoice',
    //             'parent' => 'invoice',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 165,
    //             'guard_name' => 'web',
    //             'name' => 'store-invoice',
    //             'parent' => 'invoice',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 166,
    //             'guard_name' => 'web',
    //             'name' => 'edit-invoice',
    //             'parent' => 'invoice',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 167,
    //             'guard_name' => 'web',
    //             'name' => 'delete-invoice',
    //             'parent' => 'invoice',
    //             'treeview' => 2
    //         ),

    //         // Ticket
    //         array(
    //             'id' => 168,
    //             'guard_name' => 'web',
    //             'name' => 'ticket',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 169,
    //             'guard_name' => 'web',
    //             'name' => 'view-ticket',
    //             'parent' => 'ticket',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 170,
    //             'guard_name' => 'web',
    //             'name' => 'store-ticket',
    //             'parent' => 'ticket',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 171,
    //             'guard_name' => 'web',
    //             'name' => 'edit-ticket',
    //             'parent' => 'ticket',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 172,
    //             'guard_name' => 'web',
    //             'name' => 'delete-ticket',
    //             'parent' => 'ticket',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 173,
    //             'guard_name' => 'web',
    //             'name' => 'assign-ticket',
    //             'parent' => 'ticket',
    //             'treeview' => 2
    //         ),

    //         // File Module
    //         array(
    //             'id' => 174,
    //             'guard_name' => 'web',
    //             'name' => 'file_module',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),

    //         // File Manager
    //         array(
    //             'id' => 175,
    //             'guard_name' => 'web',
    //             'name' => 'file_manager',
    //             'parent' => 'file_module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 176,
    //             'guard_name' => 'web',
    //             'name' => 'view-file_manager',
    //             'parent' => 'file_manager',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 177,
    //             'guard_name' => 'web',
    //             'name' => 'store-file_manager',
    //             'parent' => 'file_manager',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 178,
    //             'guard_name' => 'web',
    //             'name' => 'edit-file_manager',
    //             'parent' => 'file_manager',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 179,
    //             'guard_name' => 'web',
    //             'name' => 'delete-file_manager',
    //             'parent' => 'file_manager',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 180,
    //             'guard_name' => 'web',
    //             'name' => 'view-file_config',
    //             'parent' => 'file_manager',
    //             'treeview' => 2
    //         ),

    //         // Official Document
    //         array(
    //             'id' => 181,
    //             'guard_name' => 'web',
    //             'name' => 'official_document',
    //             'parent' => 'file_module',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 182,
    //             'guard_name' => 'web',
    //             'name' => 'view-official_document',
    //             'parent' => 'official_document',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 183,
    //             'guard_name' => 'web',
    //             'name' => 'store-official_document',
    //             'parent' => 'official_document',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 184,
    //             'guard_name' => 'web',
    //             'name' => 'edit-official_document',
    //             'parent' => 'official_document',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 185,
    //             'guard_name' => 'web',
    //             'name' => 'delete-official_document',
    //             'parent' => 'official_document',
    //             'treeview' => 2
    //         ),

    //         // Event Meeting
    //         array(
    //             'id' => 186,
    //             'guard_name' => 'web',
    //             'name' => 'event-meeting',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),

    //         // Meeting
    //         array(
    //             'id' => 187,
    //             'guard_name' => 'web',
    //             'name' => 'meeting',
    //             'parent' => 'event-meeting',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 188,
    //             'guard_name' => 'web',
    //             'name' => 'view-meeting',
    //             'parent' => 'meeting',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 189,
    //             'guard_name' => 'web',
    //             'name' => 'store-meeting',
    //             'parent' => 'meeting',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 190,
    //             'guard_name' => 'web',
    //             'name' => 'edit-meeting',
    //             'parent' => 'meeting',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 191,
    //             'guard_name' => 'web',
    //             'name' => 'delete-meeting',
    //             'parent' => 'meeting',
    //             'treeview' => 2
    //         ),

    //         // Event
    //         array(
    //             'id' => 192,
    //             'guard_name' => 'web',
    //             'name' => 'event',
    //             'parent' => 'event-meeting',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 193,
    //             'guard_name' => 'web',
    //             'name' => 'view-event',
    //             'parent' => 'event',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 194,
    //             'guard_name' => 'web',
    //             'name' => 'store-event',
    //             'parent' => 'event',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 195,
    //             'guard_name' => 'web',
    //             'name' => 'edit-event',
    //             'parent' => 'event',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 196,
    //             'guard_name' => 'web',
    //             'name' => 'delete-event',
    //             'parent' => 'event',
    //             'treeview' => 2
    //         ),

    //         // assets-and-category
    //         array(
    //             'id' => 197,
    //             'guard_name' => 'web',
    //             'name' => 'assets-and-category',
    //             'parent' => null,
    //             'treeview' => 2
    //         ),

    //         // category
    //         array(
    //             'id' => 198,
    //             'guard_name' => 'web',
    //             'name' => 'category',
    //             'parent' => 'assets-and-category',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 199,
    //             'guard_name' => 'web',
    //             'name' => 'view-category',
    //             'parent' => 'category',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 200,
    //             'guard_name' => 'web',
    //             'name' => 'store-category',
    //             'parent' => 'category',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 201,
    //             'guard_name' => 'web',
    //             'name' => 'edit-category',
    //             'parent' => 'category',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 202,
    //             'guard_name' => 'web',
    //             'name' => 'delete-category',
    //             'parent' => 'category',
    //             'treeview' => 2
    //         ),

    //         // assets
    //         array(
    //             'id' => 203,
    //             'guard_name' => 'web',
    //             'name' => 'assets',
    //             'parent' => 'assets-and-category',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 204,
    //             'guard_name' => 'web',
    //             'name' => 'view-assets',
    //             'parent' => 'assets',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 205,
    //             'guard_name' => 'web',
    //             'name' => 'store-assets',
    //             'parent' => 'assets',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 206,
    //             'guard_name' => 'web',
    //             'name' => 'edit-assets',
    //             'parent' => 'assets',
    //             'treeview' => 2
    //         ),
    //         array(
    //             'id' => 207,
    //             'guard_name' => 'web',
    //             'name' => 'delete-assets',
    //             'parent' => 'assets',
    //             'treeview' => 2
    //         ),
    //     ];
    // }

    // private function treeview3() : array
    // {
    //     return array(
    //         // Finance
    //         array(
    //             'id' => 208,
    //             'guard_name' => 'web',
    //             'name' => 'finance',
    //             'parent' => null,
    //             'treeview' => 3
    //         ),

    //         // Account
    //         array(
    //             'id' => 209,
    //             'guard_name' => 'web',
    //             'name' => 'account',
    //             'parent' => 'finance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 210,
    //             'guard_name' => 'web',
    //             'name' => 'view-account',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 211,
    //             'guard_name' => 'web',
    //             'name' => 'store-account',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 212,
    //             'guard_name' => 'web',
    //             'name' => 'edit-account',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 213,
    //             'guard_name' => 'web',
    //             'name' => 'delete-account',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 214,
    //             'guard_name' => 'web',
    //             'name' => 'view-transaction',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 215,
    //             'guard_name' => 'web',
    //             'name' => 'view-balance_transfer',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 216,
    //             'guard_name' => 'web',
    //             'name' => 'store-balance_transfer',
    //             'parent' => 'account',
    //             'treeview' => 3
    //         ),

    //         // expense
    //         array(
    //             'id' => 217,
    //             'guard_name' => 'web',
    //             'name' => 'expense',
    //             'parent' => 'finance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 218,
    //             'guard_name' => 'web',
    //             'name' => 'view-expense',
    //             'parent' => 'expense',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 219,
    //             'guard_name' => 'web',
    //             'name' => 'store-expense',
    //             'parent' => 'expense',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 220,
    //             'guard_name' => 'web',
    //             'name' => 'edit-expense',
    //             'parent' => 'expense',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 221,
    //             'guard_name' => 'web',
    //             'name' => 'delete-expense',
    //             'parent' => 'expense',
    //             'treeview' => 3
    //         ),

    //         // deposit
    //         array(
    //             'id' => 222,
    //             'guard_name' => 'web',
    //             'name' => 'deposit',
    //             'parent' => 'finance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 223,
    //             'guard_name' => 'web',
    //             'name' => 'view-deposit',
    //             'parent' => 'deposit',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 224,
    //             'guard_name' => 'web',
    //             'name' => 'store-deposit',
    //             'parent' => 'deposit',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 225,
    //             'guard_name' => 'web',
    //             'name' => 'edit-deposit',
    //             'parent' => 'deposit',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 226,
    //             'guard_name' => 'web',
    //             'name' => 'delete-deposit',
    //             'parent' => 'deposit',
    //             'treeview' => 3
    //         ),

    //         // payer
    //         array(
    //             'id' => 227,
    //             'guard_name' => 'web',
    //             'name' => 'payer',
    //             'parent' => 'finance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 228,
    //             'guard_name' => 'web',
    //             'name' => 'view-payer',
    //             'parent' => 'payer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 229,
    //             'guard_name' => 'web',
    //             'name' => 'store-payer',
    //             'parent' => 'payer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 230,
    //             'guard_name' => 'web',
    //             'name' => 'edit-payer',
    //             'parent' => 'payer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 231,
    //             'guard_name' => 'web',
    //             'name' => 'delete-payer',
    //             'parent' => 'payer',
    //             'treeview' => 3
    //         ),

    //         // payee
    //         array(
    //             'id' => 232,
    //             'guard_name' => 'web',
    //             'name' => 'payee',
    //             'parent' => 'finance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 233,
    //             'guard_name' => 'web',
    //             'name' => 'view-payee',
    //             'parent' => 'payee',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 234,
    //             'guard_name' => 'web',
    //             'name' => 'store-payee',
    //             'parent' => 'payee',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 235,
    //             'guard_name' => 'web',
    //             'name' => 'edit-payee',
    //             'parent' => 'payee',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 236,
    //             'guard_name' => 'web',
    //             'name' => 'delete-payee',
    //             'parent' => 'payee',
    //             'treeview' => 3
    //         ),

    //         // Training Module
    //         array(
    //             'id' => 237,
    //             'guard_name' => 'web',
    //             'name' => 'training_module',
    //             'parent' => null,
    //             'treeview' => 3
    //         ),

    //         // trainer
    //         array(
    //             'id' => 238,
    //             'guard_name' => 'web',
    //             'name' => 'trainer',
    //             'parent' => 'training_module',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 239,
    //             'guard_name' => 'web',
    //             'name' => 'view-trainer',
    //             'parent' => 'trainer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 240,
    //             'guard_name' => 'web',
    //             'name' => 'store-trainer',
    //             'parent' => 'trainer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 241,
    //             'guard_name' => 'web',
    //             'name' => 'edit-trainer',
    //             'parent' => 'trainer',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 242,
    //             'guard_name' => 'web',
    //             'name' => 'delete-trainer',
    //             'parent' => 'trainer',
    //             'treeview' => 3
    //         ),

    //         // training
    //         array(
    //             'id' => 243,
    //             'guard_name' => 'web',
    //             'name' => 'training',
    //             'parent' => 'training_module',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 244,
    //             'guard_name' => 'web',
    //             'name' => 'view-training',
    //             'parent' => 'training',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 245,
    //             'guard_name' => 'web',
    //             'name' => 'store-training',
    //             'parent' => 'training',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 246,
    //             'guard_name' => 'web',
    //             'name' => 'edit-training',
    //             'parent' => 'training',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 247,
    //             'guard_name' => 'web',
    //             'name' => 'delete-training',
    //             'parent' => 'training',
    //             'treeview' => 3
    //         ),

    //         // announcement
    //         array(
    //             'id' => 248,
    //             'guard_name' => 'web',
    //             'name' => 'announcement',
    //             'parent' => null,
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 249,
    //             'guard_name' => 'web',
    //             'name' => 'store-announcement',
    //             'parent' => 'announcement',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 250,
    //             'guard_name' => 'web',
    //             'name' => 'edit-announcement',
    //             'parent' => 'announcement',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 251,
    //             'guard_name' => 'web',
    //             'name' => 'delete-announcement',
    //             'parent' => 'announcement',
    //             'treeview' => 3
    //         ),

    //         // policy
    //         array(
    //             'id' => 252,
    //             'guard_name' => 'web',
    //             'name' => 'policy',
    //             'parent' => null,
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 253,
    //             'guard_name' => 'web',
    //             'name' => 'store-policy',
    //             'parent' => 'policy',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 254,
    //             'guard_name' => 'web',
    //             'name' => 'edit-policy',
    //             'parent' => 'policy',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 255,
    //             'guard_name' => 'web',
    //             'name' => 'delete-policy',
    //             'parent' => 'policy',
    //             'treeview' => 3
    //         ),

    //         // performance
    //         array(
    //             'id' => 256,
    //             'guard_name' => 'web',
    //             'name' => 'performance',
    //             'parent' => null,
    //             'treeview' => 3
    //         ),

    //         // goal-type
    //         array(
    //             'id' => 257,
    //             'guard_name' => 'web',
    //             'name' => 'goal-type',
    //             'parent' => 'performance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 258,
    //             'guard_name' => 'web',
    //             'name' => 'view-goal-type',
    //             'parent' => 'goal-type',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 259,
    //             'guard_name' => 'web',
    //             'name' => 'store-goal-type',
    //             'parent' => 'goal-type',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 260,
    //             'guard_name' => 'web',
    //             'name' => 'edit-goal-type',
    //             'parent' => 'goal-type',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 261,
    //             'guard_name' => 'web',
    //             'name' => 'delete-goal-type',
    //             'parent' => 'goal-type',
    //             'treeview' => 3
    //         ),

    //         // goal-tracking
    //         array(
    //             'id' => 262,
    //             'guard_name' => 'web',
    //             'name' => 'goal-tracking',
    //             'parent' => 'performance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 263,
    //             'guard_name' => 'web',
    //             'name' => 'view-goal-tracking',
    //             'parent' => 'goal-tracking',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 264,
    //             'guard_name' => 'web',
    //             'name' => 'store-goal-tracking',
    //             'parent' => 'goal-tracking',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 265,
    //             'guard_name' => 'web',
    //             'name' => 'edit-goal-tracking',
    //             'parent' => 'goal-tracking',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 266,
    //             'guard_name' => 'web',
    //             'name' => 'delete-goal-tracking',
    //             'parent' => 'goal-tracking',
    //             'treeview' => 3
    //         ),

    //         // indicator
    //         array(
    //             'id' => 267,
    //             'guard_name' => 'web',
    //             'name' => 'indicator',
    //             'parent' => 'performance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 268,
    //             'guard_name' => 'web',
    //             'name' => 'view-indicator',
    //             'parent' => 'indicator',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 269,
    //             'guard_name' => 'web',
    //             'name' => 'store-indicator',
    //             'parent' => 'indicator',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 270,
    //             'guard_name' => 'web',
    //             'name' => 'edit-indicator',
    //             'parent' => 'indicator',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 271,
    //             'guard_name' => 'web',
    //             'name' => 'delete-indicator',
    //             'parent' => 'indicator',
    //             'treeview' => 3
    //         ),

    //         // appraisal
    //         array(
    //             'id' => 272,
    //             'guard_name' => 'web',
    //             'name' => 'appraisal',
    //             'parent' => 'performance',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 273,
    //             'guard_name' => 'web',
    //             'name' => 'view-appraisal',
    //             'parent' => 'appraisal',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 274,
    //             'guard_name' => 'web',
    //             'name' => 'store-appraisal',
    //             'parent' => 'appraisal',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 275,
    //             'guard_name' => 'web',
    //             'name' => 'edit-appraisal',
    //             'parent' => 'appraisal',
    //             'treeview' => 3
    //         ),
    //         array(
    //             'id' => 276,
    //             'guard_name' => 'web',
    //             'name' => 'delete-appraisal',
    //             'parent' => 'appraisal',
    //             'treeview' => 3
    //         ),
    //     );
    // }

    // private function customize() : array
    // {
    //     return [
    //         [
	// 			'id' => 277,
	// 			'guard_name' => 'web',
	// 			'name' => 'store-user',
    //             'parent'=> 'user',
    //             'treeview'=> 1
    //         ],
    //     ];
    // }
}

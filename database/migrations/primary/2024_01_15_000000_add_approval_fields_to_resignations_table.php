<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalFieldsToResignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resignations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('resignation_date');
            $table->boolean('hr_approved')->default(false)->after('status');
            $table->boolean('admin_approved')->default(false)->after('hr_approved');
            $table->unsignedBigInteger('hr_approved_by')->nullable()->after('admin_approved');
            $table->unsignedBigInteger('admin_approved_by')->nullable()->after('hr_approved_by');
            $table->timestamp('hr_approved_at')->nullable()->after('admin_approved_by');
            $table->timestamp('admin_approved_at')->nullable()->after('hr_approved_at');
            $table->text('hr_approval_notes')->nullable()->after('admin_approved_at');
            $table->text('admin_approval_notes')->nullable()->after('hr_approval_notes');
            
            // Foreign key constraints
            $table->foreign('hr_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('admin_approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resignations', function (Blueprint $table) {
            $table->dropForeign(['hr_approved_by']);
            $table->dropForeign(['admin_approved_by']);
            $table->dropColumn([
                'status',
                'hr_approved',
                'admin_approved',
                'hr_approved_by',
                'admin_approved_by',
                'hr_approved_at',
                'admin_approved_at',
                'hr_approval_notes',
                'admin_approval_notes'
            ]);
        });
    }
}


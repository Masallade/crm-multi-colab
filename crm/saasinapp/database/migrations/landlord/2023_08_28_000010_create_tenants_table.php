<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('customer_id');
            $table->foreignId('package_id');
            $table->json('data')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('package_id', 'tenants_package_id_foreign')->references('id')->on('packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('customer_id', 'tenants_customer_id_foreign')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropForeign('tenants_package_id_foreign');
            $table->dropForeign('tenants_customer_id_foreign');
            $table->dropIfExists('tenants');
        });
    }
}

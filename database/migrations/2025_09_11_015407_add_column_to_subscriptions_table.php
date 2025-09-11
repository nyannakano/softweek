<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('payment_url')->nullable();
            $table->dropColumn('transport');
            $table->dropForeign(['lunch_id']);
            $table->dropColumn('lunch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('payment_url');
            $table->boolean('transport')->default(false);
            $table->unsignedBigInteger('lunch_id')->nullable();
            $table->foreign('lunch_id')->references('id')->on('lunches')->onDelete('cascade');
        });
    }
};

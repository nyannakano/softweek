<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('lunch_id')->nullable()->after('payment_id');
            $table->foreign('lunch_id')->references('id')->on('lunches');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['lunch_id']);
            $table->dropColumn('lunch_id');
        });
    }
};

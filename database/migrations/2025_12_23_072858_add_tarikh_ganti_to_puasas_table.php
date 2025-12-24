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
    Schema::table('puasas', function (Blueprint $table) {
        $table->date('tarikh_ganti')->nullable()->after('jumlah_hari');
    });
}

public function down(): void
{
    Schema::table('puasas', function (Blueprint $table) {
        $table->dropColumn('tarikh_ganti');
    });
}
};

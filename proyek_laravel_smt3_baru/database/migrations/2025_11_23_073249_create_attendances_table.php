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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable();
            $table->integer('total_jam')->default(0)->comment('Total jam kerja dalam jam');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha', 'terlambat'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Index untuk performance
            $table->index('employee_id');
            $table->index('tanggal');
            $table->index('status');
            $table->index(['employee_id', 'tanggal']);

            // Unique constraint untuk mencegah duplikasi absensi per hari per pegawai
            $table->unique(['employee_id', 'tanggal'], 'unique_employee_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

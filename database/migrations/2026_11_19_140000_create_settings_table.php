<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default school settings
        DB::table('settings')->insert([
            [
                'key' => 'school_name',
                'value' => 'SMKN 6 JEMBER',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'school_logo',
                'value' => 'images/logo_smk6.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_title',
                'value' => 'Aplikasi Pencatat Kehadiran Siswa Kelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

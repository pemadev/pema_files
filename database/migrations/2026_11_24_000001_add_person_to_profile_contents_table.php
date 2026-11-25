<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nama & jabatan orang pada foto (dipakai bagian Stakeholder di halaman Profil).
 * SQL manual yang setara:
 *   ALTER TABLE `profile_contents`
 *     ADD COLUMN `person_name` VARCHAR(255) NULL DEFAULT NULL AFTER `image_left`,
 *     ADD COLUMN `person_position` VARCHAR(255) NULL DEFAULT NULL AFTER `person_name`;
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile_contents', function (Blueprint $table) {
            if (! Schema::hasColumn('profile_contents', 'person_name')) {
                $table->string('person_name')->nullable()->after('image_left');
            }
            if (! Schema::hasColumn('profile_contents', 'person_position')) {
                $table->string('person_position')->nullable()->after('person_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profile_contents', function (Blueprint $table) {
            $table->dropColumn(array_values(array_filter(
                ['person_name', 'person_position'],
                fn ($c) => Schema::hasColumn('profile_contents', $c)
            )));
        });
    }
};

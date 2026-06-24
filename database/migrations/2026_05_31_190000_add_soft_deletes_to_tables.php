<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile_contents', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('businesses', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('news', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('galleries', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('reports', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('agenda', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('teams', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('partners', fn (Blueprint $t) => $t->softDeletes());
        Schema::table('settings', fn (Blueprint $t) => $t->softDeletes());
    }

    public function down(): void
    {
        Schema::table('profile_contents', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('businesses', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('news', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('galleries', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('reports', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('agenda', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('teams', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('partners', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('settings', fn (Blueprint $t) => $t->dropSoftDeletes());
    }
};

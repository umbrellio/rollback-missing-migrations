<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFeatureTable1 extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            Schema::table('feature_table1', function (Blueprint $table) {
                $table->string('name');
                $table->string('code');
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            Schema::table('feature_table1', function (Blueprint $table) {
                $table->dropColumn(['name', 'code']);
            });
        });
    }
}

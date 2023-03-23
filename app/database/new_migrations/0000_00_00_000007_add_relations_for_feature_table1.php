<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRelationsForFeatureTable1 extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            Schema::table('feature_table1', function (Blueprint $table) {
                $table
                    ->bigInteger('feature_table2_id')
                    ->nullable(true);
                $table
                    ->foreign('feature_table2_id')
                    ->on('feature_table2')
                    ->references('id');
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            Schema::table('feature_table1', function (Blueprint $table) {
                $table->dropColumn(['feature_table2_id']);
            });
        });
    }
}

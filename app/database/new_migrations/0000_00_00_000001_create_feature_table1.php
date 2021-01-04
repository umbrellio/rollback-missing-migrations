<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFeatureTable1 extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            Schema::create('feature_table1', function (Blueprint $table) {
                $table->bigIncrements('id');
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            Schema::drop('feature_table1');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsAttackPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attack_plans', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('description')->change();
            $table->float('value')->change();
            $table->text('created_at')->change();
            $table->text('updated_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attack_plans', function (Blueprint $table) {
            //
        });
    }
}

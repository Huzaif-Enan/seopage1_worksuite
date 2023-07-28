<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_delays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pm_id');
            $table->unsignedBigInteger('project_id');
            $table->string('status')->default('pending');
            $table->text('pm_text');
            $table->text('admin_text')->nullable();
            $table->json('pm_file')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->integer('extra_time')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_delays');
    }
};

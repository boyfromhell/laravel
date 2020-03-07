<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('fhunt_id');
            $table->string('name');
            $table->text('description');
            $table->integer('status_id')
                ->default(0);
            $table->json('budget')
                ->nullable(true);
            $table->integer('bid_count')
                ->default(0);
            $table->boolean('is_remote_job')
                ->default(false);
            $table->boolean('is_premium')
                ->default(false);
            $table->boolean('is_only_for_plus')
                ->default(false);
            $table->json('location')
                ->nullable(true);
            $table->string('safe_type')
                ->nullable(true);
            $table->boolean('is_personal')
                ->default(false);
            $table->integer('employer_id');
            $table->integer('freelancer_id')
                ->nullable(true);
            $table->json('updates')
                ->nullable(true);
            $table->dateTimeTz('published_at');
            $table->dateTimeTz('expired_at');
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
        Schema::dropIfExists('projects');
    }
}

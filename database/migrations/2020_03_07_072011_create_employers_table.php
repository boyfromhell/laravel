<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->integer('fhunt_id');
            $table->string('login');
            $table->string('first_name');
            $table->string('last_name');
            $table->json('avatar')
                ->nullable(true);
            $table->dateTimeTz('birth_date')
                ->nullable(true);
            $table->dateTimeTz('created')
                ->nullable(true);
            $table->text('cv')
                ->nullable(true);
            $table->integer('rating')
                ->default(0);
            $table->integer('rating_position')
                ->default(0);
            $table->integer('arbitrages')
                ->default(0);
            $table->integer('positive_reviews')
                ->default(0);
            $table->integer('negative_reviews')
                ->default(0);
            $table->text('plus_ends_at')
                ->nullable(true);
            $table->boolean('is_plus_active')
                ->default(false);
            $table->boolean('is_online')
                ->default(false);
            $table->dateTimeTz('visited_at')
                ->nullable(true);
            $table->json('location')
                ->nullable(true);
            $table->json('verification')
                ->nullable(true);
            $table->json('contacts')
                ->nullable(true);
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
        Schema::dropIfExists('employers');
    }
}

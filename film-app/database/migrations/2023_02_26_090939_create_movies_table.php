<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->text('title');
            $table->text('origin_name');
            $table->text('slug');
            $table->text('description');
            $table->text('tags');
            $table->text('image');
            $table->text('link_image');
            $table->string('episode_current', '20')->nullable();
            $table->string('episode_total', '20');
            $table->Integer('lang')->default(0);
            $table->Integer('quality')->default(0);
            $table->Integer('most_view')->default(0);
            $table->Integer('movie_hot')->default(0);
            $table->Integer('type')->default(0);
            $table->Integer('status_movie')->default(0);
            $table->Integer('status')->default(0);
            $table->bigInteger('view')->default(1);
            $table->Integer('season')->nullable();
            $table->text('trailer_url')->nullable();
            $table->text('time');
            $table->Integer('year')->nullable();
            $table->text('actor')->nullable();
            $table->text('director')->nullable();
            $table->string('category_id');
            $table->string('genre_id');
            $table->string('country_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('movies');
    }
}
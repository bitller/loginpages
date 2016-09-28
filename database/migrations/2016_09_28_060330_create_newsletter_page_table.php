<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create the newsletter_page table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateNewsletterPageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('newsletter_page', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('newsletter_id')->unsigned();
            $table->bigInteger('page_id')->unsigned();
            $table->timestamps();
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('newsletter_page');
    }
}

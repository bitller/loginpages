<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create newsletters table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail>
 */
class CreateNewslettersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('newsletters', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('number')->unsigned()->default(1);
            $table->tinyInteger('pages')->unsigned()->default(0);
            $table->boolean('sent')->default(false);
            $table->timestamp('sent_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('newsletters');
    }
}

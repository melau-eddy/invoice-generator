<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->timestamps();
            $table->unsignedBigInteger('item_id');
            $table->string('quantity');
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign(['item_id', 'invoice_id']);
            $table->dropColumn(['item_id', 'invoice_id']);
            $table->dropIfExists();
        });
    }
}


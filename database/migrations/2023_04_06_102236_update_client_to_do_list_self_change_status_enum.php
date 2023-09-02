<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\DB;
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
    DB::statement("ALTER TABLE client_to_do_list_self MODIFY COLUMN status ENUM('accepted', 'rejected','pending', 'completed') DEFAULT 'pending'");
    }

public function down()
    {
    DB::statement("ALTER TABLE client_to_do_list_self MODIFY COLUMN status ENUM('declined', 'booked', 'pending', 'completed') DEFAULT 'booked'");
    }
};

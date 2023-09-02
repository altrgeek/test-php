<?php

use App\Models\Roles\Admin;
use App\Models\Roles\SuperAdmin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSuperAdminAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_super_admin_appointments', function (Blueprint $table) {
            $table->id();

            $table->uuid('uid')->unique(); // Unique appointment ID

            $table->string('title', 100);
            $table->mediumText('description');

            // Appointment starting and time and duration
            $table->timestamp('start');
            $table->integer('duration'); // end - start = duration

            $table->enum('status', [
                'declined', // The appointment has been declined by super-admin
                'pending', // Reviewed by super-admin, scheduled for start time
                'completed' // Session was completed
            ])->default('pending');

            $table->uuid('meeting_id')->nullable(); // Unique meeting ID

            $table->enum('meeting_platform',
                ['Cognimeet', 'Zoom Meet', 'Google Meet']
            )->nullable();

            $table->foreignIdFor(SuperAdmin::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Admin::class)->constrained()->cascadeOnDelete();

            // Who requested (created) the appointment
            $table->enum('requested_by', ['super_admin', 'admin']);

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
        Schema::dropIfExists('admin_super_admin_appointments');
    }
}

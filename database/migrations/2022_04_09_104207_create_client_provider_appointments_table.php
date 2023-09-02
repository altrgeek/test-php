<?php

use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProviderAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_provider_appointments', function (Blueprint $table) {
            $table->id();

            $table->uuid('uid')->unique(); // Unique appointment ID

            $table->string('title', 100);
            $table->mediumText('description');

            // Appointment starting and time and duration
            $table->timestamp('start');
            $table->integer('duration'); // end - start = duration

            $table->enum('status', [
                'declined', // The appointment has been declined by the provider
                'booked', // The appointment has been created but not reviewed yet
                'reviewed', // Reviewed and waiting for payment form the client
                'pending', // Paid by client, scheduled for start time
                'completed' // Session was completed
            ])->default('booked');

            $table->uuid('meeting_id')->nullable(); // Unique meeting ID

            $table->enum('meeting_platform',
            ['Cognimeet', 'Zoom Meet', 'Google Meet']
            )->nullable();

            $table->foreignIdFor(Provider::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();

            // Who requested (created) the appointment
            $table->enum('requested_by', ['provider', 'client']);

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
        Schema::dropIfExists('client_provider_appointments');
    }
}

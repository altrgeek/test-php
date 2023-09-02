<?php

namespace App\Traits;

use CStr;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait HandlesAppointments
{
    /**
     * Parses `start` and `end` property of `appointment` and converts it from
     * MySQL's native DateTime to proper validated string which can be used in
     * custom calendar widget
     *
     * @param \Illuminate\Database\Eloquent\Model  $appointment
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function parseTime(Model $appointment): Model
    {
        $appointment->start_time = (new Carbon($appointment->start))->format('D jS M Y \a\t h:i:s A');
        $start_time = (int) (new Carbon($appointment->start))->format('U');
        $appointment->end_time = (new Carbon($start_time + (int) $appointment->duration))
            ->format('D jS M Y \a\t h:i:s A');

        return $appointment;
    }

    /**
     * Applies `parseTime` method to a collection of appointment models
     *
     * @param \Illuminate\Database\Eloquent\Collection  $appointments
     *
     * @return \Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>
     */
    protected function parseTimeCollectively(Collection $appointments): Collection
    {
        return $appointments->map(function (Model $appointment) {
            return $this->parseTime($appointment);
        });
    }

    /**
     * Parses the `start_date`, `start_time`, `end_date` and `end_time` fields
     * from request input and converts them to an array of UNIX timestamps
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return array
     */
    protected function convertToTimestamp(Request $request): array
    {
        // The final result will be an associative array in following format
        // ['start' => UnixTimestamp, 'end' => 'UnixTimestamp']
        return collect(['start' => 'start', 'end' => 'end'])
            ->map(function (string $time) use ($request): Carbon {
                // Carbon will automatically detect the input format and will
                // parse the datetime string to a `Carbon` instance
                return new Carbon(sprintf(
                    '%s %s',
                    $request->input($time . '_date'), // start_date, end_date
                    $request->input($time . '_time'), // start_time, end_time
                ));
            })->map(function (Carbon $date): int {
                // Convert the `Carbon` instance to UNIX timestamp
                return (int) $date->format('U');
            })->toArray(); // Convert the collection to associative array
    }

    /**
     * Runs predefined appointment data validation rules on passed request
     * instance and also checks for the record key and model existence in
     * appropriate table of specified model name
     *
     * @param Illuminate\Http\Request  $request
     * @param array                    $models
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    protected function validateData(Request $request, ?array $models = null): array
    {
        $foreign_data = [];

        // $models = ['client', 'provider']
        // $result = ['clients' => 'client_id', 'providers' => 'provider_id']
        // Used in `Rule::unique` to make sure record exists for passed model
        // name (singular) in guessed table
        if (is_array($models))
            foreach ($models as $model) {
                if (!CStr::isValidString($model)) continue;

                // $model = client => `clients` (table name)
                $table_name = Str::plural($model);
                // $model = client => `client_id` (foreign key)
                $column_name = sprintf('%s_id', $model);

                // $model = client => ['clients' => 'client_id']
                $foreign_data[$table_name] = $column_name;
            }

        return $request->validate(
            $this->validationRules($foreign_data)
        );
    }

    /**
     * Returns the predefined validation rules for appointment request and also
     * checks model ID for specified model name and applies record existence
     * rule to make sure illegal foreign key constraints are not formed
     *
     * @param array  $foreign_data
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    protected function validationRules(?array $foreign_data = null): array
    {
        $rules = [
            'title'       => ['required', 'string', 'min:3', 'max:100'],
            'start_date'  => ['required', 'date_format:Y-m-d'],
            'start_time'  => ['required', 'date_format:H:i:s'],
            'end_date'    => ['required', 'date_format:Y-m-d'],
            'end_time'    => ['required', 'date_format:H:i:s'],
            'description' => ['required', 'string', 'min:20'],
            'meeting_platform' => ['string'],
        ];

        // If models are passed then make strict numeric validation on the
        // foreign id field and also check if record exists against passed
        // foreign id
        if (is_array($foreign_data))
            foreach ($foreign_data as $table => $column) {
                $rules[$column] = [
                    'required',
                    'numeric',
                    Rule::exists($table, 'id')
                ];
            }

        return $rules;
    }

    /**
     * Prepares appointment data for insertion/update, must validate request
     * before passing to this function!
     *
     * @param \Illuminate\Http\Request  $request
     * @param array  $keys
     *
     * @return array
     */
    protected function prepareData(Request $request, string $from, ?array $fields = null): array
    {
        $timings = $this->convertToTimestamp($request);

        $data = [
            'title'        => $request->title,
            'description'  => $request->description,
            'start'        => $timings['start'],
            'duration'     => $timings['end'] - $timings['start'],
            'requested_by' => $from
        ];

        // If valid keys are passed then include them on prepared data set
        if (is_array($fields))
            foreach ($fields as $column_name => $value)
                $data[$column_name] = $value;

        return $data; // Return the formatted data set
    }

    protected function praseDateAndTime(Model $appointment): Model
    {
        $start_time = (int) (new Carbon($appointment->start))->format('U');
        $end_time = $start_time + $appointment->duration;

        $appointment->start_date = (new Carbon($start_time))->format('Y-m-d');
        $appointment->end_date = (new Carbon($end_time))->format('Y-m-d');
        $appointment->start_time = (new Carbon($start_time))->format('H:i:s');
        $appointment->end_time = (new Carbon($end_time))->format('H:i:s');

        return $appointment;
    }

    /**
     * Ensures that each key of the array is a string and value is a non-zero
     * and non-negative integer (primary key)
     *
     * @param array $array
     * @throws \Exception
     */
    protected function validateForeignKeys(array $array)
    {
        foreach ($array as $key => $value)
            if (!is_string($key) || strlen($key) <= 2 || !is_int($value))
                throw new Exception("Invalid foreign key/value pair provided!");
    }

    protected function applyHelperProps(Model $appointment, bool $received = false, bool $parseTime = true)
    {
        if ($parseTime)
            $this->parseTime($appointment);

        // Appointment type
        $appointment->isReceived = $received;
        $appointment->isRequested = !$received;

        // dd($appointment->isBooked());

        $appointment->isReady = $appointment->isPending(); // Ready, pending for session
        $appointment->isPending = $appointment->isPending(); // Paid/reviewed pending for session
        $appointment->isCompleted = $appointment->isCompleted(); // Completed
        $appointment->isDeclined = $appointment->isDeclined();
        $appointment->isBooked = $appointment->isBooked();
        $appointment->isReviewed = $appointment->isReviewed();

        // Everything is false by default
        $appointment->isEditable = false;
        $appointment->isDeletable = false;
        $appointment->isDeclinable = false;
        $appointment->isReviewable = false;

        // Received
        if ($received) {
            $appointment->isDeclinable = $appointment->isBooked(); // Can decline if not reviewed
            // Can review if not already reviewed yet
            $appointment->isReviewable = $appointment->isBooked();
        }

        // Requested
        if (!$received) {
            $appointment->isEditable = $appointment->isBooked(); // Can edit if not reviewed
            $appointment->isDeletable = $appointment->isBooked(); // Can delete if not reviewed
        }

        switch ($appointment->status) {
            case 'declined':
                $appointment->state = 'declined';
                break;
            case 'booked':
                $appointment->state = 'pending review';
                break;
            case 'reviewed':
                $appointment->state = 'unpaid';
                break;
            case 'pending':
                $appointment->state = 'ready';
                break;
            case 'completed':
                $appointment->state = 'completed';
                break;
        }

        return $appointment;
    }

    protected function applyHelperPropsCollectively(Collection $appointments, bool $received = false, bool $parseTime = true)
    {
        return $appointments->map(function (Model $appointment) use ($received, $parseTime) {
            return $this->applyHelperProps($appointment, $received, $parseTime);
        });
    }

    protected function generateMeetingId(): string
    {
        return Str::orderedUuid();
    }
}

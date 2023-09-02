<x-dashboard title="Appointment Details">
    <x-slot name="addBtn">
        <div class="d-flex">
            {{-- Can only perform operations if not completed yet --}}
            @if (!$appointment->isCompleted)

                {{-- Can edit/delete only if requested --}}
                @if ($appointment->isRequested)
                    {{-- Can be edited if not completed yet --}}
                    <a href={{ route('admin.dashboard.appointments.super_admin.edit', $appointment->id) }} type="button"
                        class="btn btn-primary mx-1">
                        <span>Edit</span>
                    </a>
                    {{-- Requested appointments can be deleted --}}
                    <form action="{{ route('admin.dashboard.appointments.super_admin.delete', $appointment->id) }}"
                        method="POST" class="ml-1">
                        @csrf
                        @method('DELETE')
                        {{-- Received appointments can be declined --}}
                        <button type="submit" class="btn btn-danger btn-dim">
                            <span>Delete</span>
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </x-slot>

    <div class="card">
        <div class="card-inner card-inner-xl">
            <div class="entry">
                <h4>{{ $appointment->title }}</h4>

                <div class="row pt-5 pb-2">
                    <div class="col-sm-6">
                        <h6>Start Time</h6>
                        <p>{{ $appointment->start_time }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h6>Ending Time</h6>
                        <p>{{ $appointment->start_time }}</p>
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-sm-6">
                        <h6>Status</h6>
                        @php
                            $className = 'primary';

                            switch ($appointment->status) {
                                case 'declined':
                                    $className = 'danger';
                                    break;
                                case 'booked':
                                    $className = 'success';
                                    break;
                                case 'reviewed':
                                    $className = 'warning';
                                    break;
                                case 'pending':
                                    $className = 'info';
                                    break;
                                case 'completed':
                                    $className = 'primary';
                                    break;
                            }
                        @endphp
                        <small class="rounded bg-{{ $className }} text-white py-1 px-3 fw-medium">
                            {{ ucfirst($appointment->state) }}
                        </small>
                    </div>
                    <div class="col-sm-6">
                        <h6>Cogni Admin Name</h6>
                        <p>{{ $appointment->superAdmin->user->name }}</p>
                    </div>
                </div>


                <div class="py-3">
                    <h6>Description</h6>
                    <p>{{ $appointment->description }}</p>
                </div>

                {{-- Can start session if link exists and is ready --}}
                @if ($appointment->isPending() && $appointment->meeting_id && $appointment->meeting_platform == "Cognimeet")
                    <a href="{{ $appointment->getMeetingUrl() }}" target="blank" role="button" class="btn btn-primary mt-3">
                        <span>Start Session</span>
                    </a>
                    @elseif ($appointment->isPending() && $appointment->meeting_id && $appointment->meeting_platform == "Zoom Meet")
                    <div class="py-3">
                        <h6>Meeting Id:</h6>
                        <span>{{ $appointment->meeting_id }}</span>
                    </div>
                    <div class="py-3">
                        <h6>Meeting Password:</h6>
                        <span>{{ $appointment_meta['zoom_password'] }}</span>
                    </div>
                    <a href="{{ $appointment_meta['join_url'] }}" target="blank" role="button" class="btn btn-primary mt-3">
                        <span>Join Session</span>
                    </a>
                    @elseif ($appointment->isPending() && $appointment->meeting_id && $appointment->meeting_platform == "Google Meet")
                    <a href="{{ $appointment_meta['join_url'] }}" target="blank" role="button" class="btn btn-primary mt-3">
                        <span>Join Session</span>
                    </a>
                @endif
            </div>
        </div><!-- .card-inner -->
    </div><!-- .card -->

</x-dashboard>

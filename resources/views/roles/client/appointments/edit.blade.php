<x-dashboard title="Edit Appointment">
    <div class="card">
        <div class="card card-inner card-inner-xl">
            <form
                action="{{ route('client.dashboard.appointments.update', $appointment->id) }}"
                method="POST">
                @method('PATCH')
                @csrf
                <div class="row gx-4 gy-3">
                    {{-- Title --}}
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-event-title">Title</label>
                            <div class="form-control-wrap">
                                <input type="text" name="title" class="form-control" id="edit-event-title"
                                    value="{{ $appointment->title }}" placeholder="Enter a descriptive breif title"
                                    required>
                            </div>
                        </div>
                    </div>

                    {{-- Start date and time --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Start Date & Time</label>
                            <div class="row gx-2">
                                <div class="w-55">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" name="start_date" id="edit-event-start-date"
                                            class="form-control date-picker" data-date-format="yyyy-mm-dd"
                                            placeholder="{{ date('Y-m-d') }}" value="{{ $appointment->start_date }}"
                                            required>
                                    </div>
                                </div>
                                <div class="w-45">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-clock"></em>
                                        </div>
                                        <input type="text" name="start_time" id="edit-event-start-time"
                                            data-time-format="HH:mm:ss" class="form-control time-picker"
                                            placeholder="{{ date('H:i:s') }}"
                                            value="{{ $appointment->start_time }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- End date and time --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">End Date & Time</label>
                            <div class="row gx-2">
                                <div class="w-55">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calendar"></em>
                                        </div>
                                        <input type="text" name="end_date" id="edit-event-end-date"
                                            class="form-control date-picker" data-date-format="yyyy-mm-dd"
                                            placeholder="{{ date('Y-m-d') }}" value="{{ $appointment->end_date }}">
                                    </div>
                                </div>
                                <div class="w-45">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-clock"></em>
                                        </div>
                                        <input type="text" name="end_time" id="edit-event-end-time"
                                            data-time-format="HH:mm:ss" class="form-control time-picker"
                                            placeholder="{{ date('H:i:s') }}" value="{{ $appointment->end_time }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="edit-event-description">Description</label>
                            <div class="form-control-wrap">
                                <textarea name="description" class="form-control"
                                    id="edit-event-description">{{ $appointment->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-dashboard>

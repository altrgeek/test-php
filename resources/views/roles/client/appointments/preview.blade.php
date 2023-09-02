<x-dashboard title="Appointment Details">
    <x-slot name="addBtn">
        <div class="d-flex">
            {{-- Can only perform operations if not completed yet --}}
            @if (!$appointment->isCompleted)

                {{-- Can edit/delete only if requested and not reviewed yet by admin --}}
                @if ($appointment->isRequested && $appointment->isBooked)
                    {{-- Can be edited if not reviewed yet --}}
                    <a href={{ route('client.dashboard.appointments.edit', $appointment->id) }} type="button"
                        class="btn btn-primary mx-1">
                        <span>Edit</span>
                    </a>
                    {{-- Requested appointments can be deleted if not reviewed yet --}}
                    <form action="{{ route('client.dashboard.appointments.delete', $appointment->id) }}"
                        method="POST" class="ml-1">
                        @csrf
                        @method('DELETE')
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
                        <h6>Provider Name</h6>
                        <p>{{ $appointment->provider->user->name }}</p>
                    </div>
                </div>


                <div class="py-3">
                    <h6>Description</h6>
                    <p>{{ $appointment->description }}</p>
                </div>

                {{-- Can start session if link exists and is ready --}}
                @if ($appointment->isPending() && $appointment->meeting_id && $appointment->meeting_platform == "Cognimeet")
                    <a href="{{ $appointment->getMeetingUrl() }}" role="button" class="btn btn-primary mt-3">
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
                    <a href="{{ $appointment_meta['join_url'] }}" role="button" class="btn btn-primary mt-3">
                        <span>Join Session</span>
                    </a>
                    @elseif ($appointment->isPending() && $appointment->meeting_id && $appointment->meeting_platform == "Google Meet")
                    <a href="{{ $appointment_meta['join_url'] }}" role="button" class="btn btn-primary mt-3">
                        <span>Join Session</span>
                    </a>
                @endif

                {{-- Can start session if link exists and is ready --}}
                @if ($appointment->isReviewed())
                    <a role="button"
                    data-appointment-id = "{{ $appointment->id }}"
                    data-order-amount = "{{ round($appointment->order->amount, 2) }}"
                    data-order-id = "{{ $appointment->order->id }}"
                     class="btn btn-info mt-3"
                     id="PayNowBtn">
                        <span>Pay Now / USD {{ round($appointment->order->amount, 2) }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="PayNowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pay Order</h5>
            </div>
            <div class="modal-body">

                <form
                action="{{ route('client.dashboard.order.create') }}"
                method="POST"
                class="subscription_payment_form"
                id="payment-form">
                    @csrf
                    <input type="hidden" name="appointment_order_id" id="order_id" value="">
                    <input type="hidden" name="appointment_order_amount" id="order_amount" value="">

                    <div id="card-element">
                      <!-- Elements will create input elements here -->
                    </div>

                    <div class="card-logos text-right mt-3">
                        <img src="{{ asset('images/card_logos/visa-logo-6F4057663D-seeklogo.com.png') }}" width="56" height="40" alt="visa-card">
                        <img src="{{ asset('images/card_logos/MasterCard_Logo.svg.png') }}" width="56" height="35" alt="master-card">
                        <img src="{{ asset('images/card_logos/american-express-logo-credit-card-payment-png-favpng-8tx6epUgjhQeNcJFzp5fhKgZQ-removebg-preview.png') }}" width="56" height="50" alt="amx-card">
                        <img src="{{ asset('images/card_logos/discover-card-logo-vector-free-11574195715ofnykwhglc-removebg-preview.png') }}" width="56" height="50" alt="discover-card">
                        <img src="https://www.jcbusa.com/wp-content/uploads/2019/08/EmblemBlue-thumbnail.jpg" width="56" height="50" alt="jcb-card">
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>

                    <button type="submit" class="btn btn-primary mt-5 subscription_payment_btn">Submit Payment</button>
                </form>
            </div>
        </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    {{-- Setting stripe publishable key to set the stripe card elements --}}
    <script type="text/javascript">
        // Set your publishable key: remember to change this to your live publishable key in production
        // See your keys here: https://dashboard.stripe.com/apikeys
        // var Publishable_key = "{{ env('STRIPE_KEY') }}";
        var stripe = Stripe('pk_test_51K3NIIAcehZZuafTtf9NQ6PZfGuNnYmHvbraQAqCUKxmin4bKDknYpnKAssVr6TdYGfpje3LjiiYefBlClZeKzDA00b6dHZEky');
        // Set up Stripe.js and Elements to use in checkout form

        var form = document.getElementById("payment-form");

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createSource(card).then(function(result) {
                if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                } else {
                // Send the source to your server
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeSource');
                    hiddenInput.setAttribute('value', result.source.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });

        });

        var elements = stripe.elements();
        var style = {
        base: {
        color: "#32325d",
        }
        };

        var card = elements.create("card", { style: style });
        card.mount("#card-element");
    </script>

    {{-- Displaying the card errors into the form --}}
    <script type="text/javascript">
        card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
        });
    </script>
</x-dashboard>

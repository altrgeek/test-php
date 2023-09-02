<x-dashboard title="Subscription Plans" description="Choose your pricing plan and start enjoying our service.">
    <div class="row g-gs">

            @foreach ($subscriptions as $subscription)
            <div class="col-md-6 col-xxl-3">
                <div class="card card-bordered pricing recommend text-center">
                    @if (empty($subscription_id) || !isset($subscription->expires_at))
                        <span class="pricing-badge badge badge-primary">Recomended</span>

                        @elseif (!empty($subscription_id) || $subscription->expires_at >= now() || $subscription->id == $subscription_id)
                        <span class="pricing-badge badge badge-primary">Purchased</span>

                        @elseif (!empty($subscription_id) || $subscription->expires_at <= now() || $subscription->id == $subscription_id)
                        <span class="pricing-badge badge badge-primary">Expired</span>
                    @endif
                    <div class="pricing-body">
                        <div class="pricing-media">
                            <img src="./images/icons/plan-s2.svg" alt="">
                        </div>
                        <div class="pricing-title w-220px mx-auto">
                            <h5 class="title">{{ $subscription->name }}</h5>
                            <span class="sub-text">{{ $subscription->description }}</span>
                        </div>
                        <div class="pricing-amount">
                            <div class="amount">${{ $subscription->price }}</div>
                            @php
                                $explode = $subscription->duration;

                                $print = explode('-', $explode);

                                $number = $print[0];

                                $duration = $print[1];
                            @endphp
                            <span class="amount">{{ $number }} {{ $duration }}</span><br>
                            <span class="bill">{{ $subscription->providers }} user</span>
                        </div>
                        <!-- Subscription trigger modal -->
                        @if (empty($subscription_id) || !isset($subscription->expires_at))
                            <div class="pricing-action">
                                <a class="btn btn-primary subscribe_btn"
                                data-subscription-duration-number = "{{ $number }}"
                                data-subscription-duration = "{{ $duration }}"
                                data-subscription-id="{{ $subscription->id }}"
                                data-subscription-name="{{ $subscription->name }}"
                                data-subscription-price="{{ $subscription->price }}">Buy Now</a>
                            </div>
                            @elseif (!empty($subscription_id) && $subscription->id == $subscription_id)
                        @endif
                    </div>
                </div><!-- .pricing -->
            </div><!-- .col -->
            @endforeach

            <!-- Subscription Modal -->
            <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <h5 class="modal-title">Subscribe To</h5>
                            <input type="text" class="border-0 bg-white font-weight-bold text-dark" disabled id="subscriptionNAMEDisplay" value="">
                        </div>
                        <div class="modal-body">

                            <h5 id="modal-body-title" class="text-center"></h5>
                            <form
                            action="{{ route('admin.dashboard.subscriptions.create') }}"
                            method="POST"
                            class="subscription_payment_form"
                            id="payment-form">
                                @csrf
                                <input type="hidden" name="subscribe_id" id="subscriptionID" value="">
                                <input type="hidden" name="subscribe_name" id="subscriptionNAME" value="">
                                <input type="hidden" name="subscribe_price" id="subscriptionPRICE" value="">
                                <input type="hidden" name="subscribe_duration_number" id="subscriptionNumber" value="">
                                <input type="hidden" name="subscribe_duration" id="subscriptionDuration" value="">

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
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    {{-- Setting stripe publishable key to set the stripe card elements --}}
    <script type="text/javascript">
        // Set your publishable key: remember to change this to your live publishable key in production
        // See your keys here: https://dashboard.stripe.com/apikeys
        var stripe = Stripe("{{ config('stripe.keys.public_key') }}");
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

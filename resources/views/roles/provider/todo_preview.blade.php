<x-dashboard title="Task Assigned by {{ $provider->name }}">
    <div class="card">
        <div class="card-inner card-inner-xl">
            <div class="entry">
                <h4>{{ $task->title }} (
                    @if ($task->status == 'pending')
                        <span>Status: </span><span class="badge text-warning">Pending</span>
                    @elseif($task->status == 'accepted')
                        <span>Status: </span><span class="badge text-primary">Accepted</span>
                    @elseif($task->status == 'rejected')
                        <span>Status: </span><span class="badge text-danger">Rejected</span>
                    @elseif($task->status == 'completed')
                        <span>Status: </span><span class="badge text-success">Completed</span>
                    @endif
                    )
                    <x-slot name="header">
                        <div class="d-flex justify-content-end align-items-center">
                                <x-dashboard.widgets.button label="Send Update" />
                        </div>
                    </x-slot>
                    <x-dashboard.widgets.modal
                    action="Send"
                    title="Send Update"
                    :url="route('dashboard.todoChat',$task)"
                    >
                            <x-dashboard.widgets.form.input
                            label="Message"
                            type="textarea"
                            name="update"
                            id="todoUpdate"
                            placeholder="Enter Update"
                            required
                            ></x-dashboard.widgets.form.input>

                    </x-dashboard.widgets.modal>
                </h4>
                

                <div class="row pt-5 pb-6">
                    <div class="col-sm-3">
                        <h6>Start Time</h6>
                        <p>{{ $task->start }}</p>
                    </div>
                    <div class="col-sm-3">
                        <h6>End Time</h6>
                        <p>{{ $task->end }}</p>
                    </div>
                    <div class="col-sm-3">
                        <h6>Duration</h6>
                        <p>{{ $task->duration." ".$task->unit }} </p>
                    </div>
                    <div class="col-sm-2">
                        @if ($task->status == 'pending')
                            <a href="{{ route('provider.accept',$task->id) }}" class="btn btn-success m-1">Accept</a>
                            <a href="{{ route('provider.reject',$task->id) }}" class="btn btn-danger m-1">Reject</a>
                        @endif
                        @if ($task->status =='accepted')
                        <a href="{{ route('provider.complete',$task->id) }}" class="btn btn-success m-1">Completed</a>
                        @endif
                        
                    </div>
                </div>
                </div>


                <div class="py-3">
                    <h6>Description</h6>
                    <p>{{ $task->description }}</p>
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

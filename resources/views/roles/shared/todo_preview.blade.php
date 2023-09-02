<x-dashboard title="Appointment Details">

    {{-- {{ dd($appointment->vrTherapy->marketplaces);}} --}}
        <div class="card">
            <div class="card-inner card-inner-xl">
                <div class="entry">
                    <h4>{{ $task->title }}</h4>
    
                    <div class="row pt-5 pb-6">
                        <div class="col-sm-3">
                            <h6>Start Time</h6>
                            <p>{{ $task->start }}</p>
                        </div>
                        <div class="col-sm-3">
                            <h6>Duration</h6>
                            <p>{{ $task->duration." ".$task->unit }} </p>
                        </div>
                        @if ($task->status != 'pending')
                        <div class="col-sm-3">
                            <h6>Status</h6>
                            <p>{{ $task->status }} </p>
                        </div>
                        @endif
                        <div class="col-sm-2">
                            @if ($task->status == 'pending')
                                <a href="{{ route('dashboard.accept',$task->id) }}" class="btn btn-success m-1">Accept</a>
                                <a href="{{ route('dashboard.reject',$task->id) }}" class="btn btn-danger m-1">Reject</a>
                            @endif
                            @if ($task->status =='accepted')
                            <a href="{{ route('dashboard.complete',$task->id) }}" class="btn btn-success m-1">Completed</a>
                            @endif
                        </div>
                    </div>
                    </div>
    
    
                    <div class="py-3">
                        <h6>Description</h6>
                        <p>{{ $task->description }}</p>
                    </div>
    
                    <div class="row mt-5">
                        <table class="nk-tb-list nk-tb-ulist ">
                            <thead>
                                <tr>
                                    {{-- {{ dd($appointment) }} --}}
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Title</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Description</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Start</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Duration</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Status</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Provider</span>
                                    </th>
                                    <th class="nk-tb-col sorting" tabindex="0">
                                        <span class="sub-text">Provider Email</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr class="nk-tb-item ">
                                        
                                        <td class="nk-tb-col">
                                            <span>{{ $task->title }}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span>{{ $task->description }}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span>{{ $task->start }}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span>{{ $task->duration." ".$task->unit }}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span>{{ $task->status}}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter">{{ $provider->name }}</span>    
                                        </td>
                                        <td class="nk-tb-col">
                                            <span class="badge bg-lighter">{{ $provider->email }}</span>    
                                        </td>
                    
                                    </tr>
                            </tbody>
                        </table>
                        
                        
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
    
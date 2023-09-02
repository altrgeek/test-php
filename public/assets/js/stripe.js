jQuery(document).ready(function ($) {
    const stripe_key = $('meta[name="stripe_pub_key"]')[0].attr("value");
    if (!stripe_key)
        throw new Error("Stripe publishable key is either empty or invalid!");

    const stripe = Stripe(stripe_key);

    const elements = stripe.elements();
    const card = elements.create("card", {
        style: { base: { color: "#32325d" } },
    });
    card.mount("#card-element");

    const payment_form = $("#payment-form").on("submit", function (event) {
        event.preventDefault();

        stripe
            .createSource(card)
            .then(function ({ error = undefined, source = undefined }) {
                if (error)
                    // Display the error message in case of error
                    return $("#card-errors").text(error.message);

                const input = $(
                    '<input type="hidden" name="stripeSource" />'
                ).val(source.id);
                $("#payment-form").push(input);
            });
    });
});

var form = document.getElementById("payment-form");

form.addEventListener("submit", function (event) {
    event.preventDefault();

    stripe.createSource(card).then(function (result) {
        if (result.error) {
            // Inform the user if there was an error
            var errorElement = document.getElementById("card-errors");
            errorElement.textContent = result.error.message;
        } else {
            // Send the source to your server
            var form = document.getElementById("payment-form");
            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "stripeSource");
            hiddenInput.setAttribute("value", result.source.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    });
});

var elements = stripe.elements();
var style = {
    base: {
        color: "#32325d",
    },
};

var card = elements.create("card", { style: style });
card.mount("#card-element");

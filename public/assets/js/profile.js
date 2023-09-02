$(document).ready(function ($) {
    // Input field which will hold the selected avatar file
    const inputField = $("#avatarInputField");

    // The element which will trigger file selection window
    $("#profileAvatarOpener").on("click", function (event) {
        event.preventDefault();

        inputField.click(); // Open the file selection window
    });

    // When user selects the image submit the form
    inputField.on("change", function () {
        // Make sure user has selected a file
        if (this.files.length) $("#profileAvatarEditForm").submit();
    });
});

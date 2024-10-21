$(document).ready(function() {

    $("#searchBox").keyup(function() {
        let inputVal = $(this).val();
        if (inputVal === "" || inputVal.endsWith(" ")) {
            $("#autocompleteBox").hide(); // Hide the box if no input or if the last character is a space
        } else {
            let words = inputVal.trim().split(" ");
            let lastWord = words.pop(); // Get the last word
            
            $.ajax({
                type: "POST",
                url: "/core/autocomplete-search.php",
                data: 'search=' + lastWord,
                beforeSend: function() {
                    // Add a loader or pre-request action if needed
                },
                success: function(data) {
                    $("#autocompleteBox").show(); // Show the box with suggestions
                    $("#autocompleteBox").html(data); // Display the results
                    $("#searchBox").css("background", "#FFF");
                }
            });
        }
    });

});

// To select a tag
function selectTag(val) {
    let inputVal = $("#searchBox").val();
    let words = inputVal.split(" ");
    words.pop(); // Remove the last word
    words.push(val); // Add the selected value
    $("#searchBox").val(words.join(" ") + " "); // Add a space after the selected word
}

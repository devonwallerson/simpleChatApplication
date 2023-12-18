$(document).ready(function(){
    let inputBoxData = {
        name: "",
        password: "",
        chatbox: "",
        otherName: ""
    };

    // Periodic AJAX request to list_names.php
    var xhr1 = new XMLHttpRequest();
    xhr1.open("GET", "listNames.php", true);
    xhr1.onreadystatechange = function() {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            document.getElementById('userList').innerHTML = xhr1.responseText;
        }
    };
    xhr1.send();

    function sendMessage(data){
        if (data !== undefined && data !== null) {
            $.ajax({
                type: "POST",
                url: "serverside.php",
                data: data,
                success: function(response) {
                    console.log("Server response:", response);
                },
                error: function (error) {
                    console.error("AJAX error2:", error);
                }
            });
            continuouslyFetchUpdates(document.getElementById("otherName"));
        } else {
            $("#warning").text("Insert Valid Username and Password.");
        }
    }

    function updateServer(htmlID) {
        $('#' + htmlID).on("keyup", function () {
            // Check if the element with the specified ID exists
            let $element = $(this);
            if ($element.length) {
                let inputVal = $element.val();
                inputBoxData[htmlID] = inputVal;
    
                clearTimeout($element.data('timer'));
                $element.data('timer', setTimeout(function () {
                    sendMessage(inputBoxData);
                }, 500));
            } else {
                console.error("Element with ID '" + htmlID + "' not found.");
            }
        });
    }
    

    // Function to continuously fetch updates from the database
   // Function to continuously fetch updates from the database for a specific username
function continuouslyFetchUpdates() {

    
    // Set an interval to fetch updates every 5 seconds
    setInterval(function(){


        var otherName = document.getElementById('otherName').value;
        console.log(otherName);

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getMessages.php?otherName=" + otherName, true);
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var jsonResponse = JSON.parse(xhr.responseText);
                document.getElementById('responseBox').innerHTML = jsonResponse.chatContent;
            }
        };
        xhr.send();
    }, 5000);
   
}

// Example: Call the function to start continuous fetching for a specific username
    

    updateServer("name");
    updateServer("password");
    updateServer("chatbox");
    // continuouslyFetchUpdates(document.getElementById("otherName"));

});

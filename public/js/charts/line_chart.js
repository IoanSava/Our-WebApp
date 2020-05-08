function compareButtonEvents() {
    // Get the modal
    var compareModal = document.getElementById("compare_modal");

    // Get the button that opens the modal
    var compareButton = document.getElementById("compare_button");

    // Get the <span> element that closes the modal
    var compareSpan = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    compareButton.onclick = function() {
        compareModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    compareSpan.onclick = function() {
        compareModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == compareModal) {
            compareModal.style.display = "none";
        }
    }
}

function checkboxlimit(checkgroup, limit) {
    var checkgroup = checkgroup;
    var limit = limit;
    for (var i = 0; i < checkgroup.length; ++i) {
        checkgroup[i].onclick = function() {
            var checkedcount = 0;
            for (var i = 0; i < checkgroup.length; ++i)
                checkedcount += (checkgroup[i].checked) ? 1 : 0;
            if (checkedcount > limit) {
                alert("You can only select a maximum of " + limit + " checkboxes");
                this.checked = false;
            }
        }
    }
}

checkboxlimit(document.forms.compare_modal.checkbox, 4);
compareButtonEvents();
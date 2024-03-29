
function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("mySidebar").style.display = "block";
    document.getElementsByClassName("content")[0].style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("mySidebar").style.display = "none";
    document.getElementsByClassName("content")[0].style.marginLeft = "0";
}
function hideDetails() {
    document.getElementById('accno').style.display = 'none';
    document.getElementById('bal').style.display = 'none';

}
document.getElementById("hide").addEventListener("click", hideDetails);

function showDetails() {
    document.getElementById('accno').style.display = 'contents';
    document.getElementById('bal').style.display = 'contents';
}
document.getElementById("view").addEventListener("click", showDetails);


// Wait for the DOM content to be loaded
document.addEventListener("DOMContentLoaded", function() {
    // Hide all content cards
    hideAllContent();
    // Show the account details card by default
    document.getElementById("accountdetails").style.display = "block";
});

// Add Student link clicked
document.getElementById("addstudentbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("addstudents").style.display = "block";
});
// Update Student link clicked
document.getElementById("updatestudentbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("updatestudents").style.display = "block";
});
// Delete Student link clicked
document.getElementById("deletestudentbutton").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("deletestudents").style.display = "block";
});
// Add Vendors link clicked
document.getElementById("addvendorsbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("addvendors").style.display = "block";
});

// Home link clicked
document.getElementById("accountdetailsbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("accountdetails").style.display = "block";
});




// Hide all content cards
function hideAllContent() {
    var contentCards = document.getElementsByClassName("content");
    for (var i = 0; i < contentCards.length; i++) {
        contentCards[i].style.display = "none";
    }
}

console.log("hello")

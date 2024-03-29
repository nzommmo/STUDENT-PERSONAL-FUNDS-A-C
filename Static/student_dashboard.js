// Wait for the DOM content to be loaded
document.addEventListener("DOMContentLoaded", function() {
    // Hide all content cards
    hideAllContent();
    // Show the account details card by default
    document.getElementById("accountdetails").style.display = "block";
});

// Deposit link clicked
document.getElementById("depositbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("depositcard").style.display = "block";
});

// Withdraw link clicked
document.getElementById("withdrawbtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("withdrawcard").style.display = "block";
});

// Transact link clicked
document.getElementById("transactbtn").addEventListener("click", function() {
    hideAllContent();
    
    // Add logic to display transact card if needed
});
// Transaction History link clicked
document.getElementById("historybtn").addEventListener("click", function() {
    hideAllContent();
    document.getElementById("transactions").style.display = "block";
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

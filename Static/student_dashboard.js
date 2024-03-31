
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


document.addEventListener("DOMContentLoaded", function() {
    // Hide all content cards
    hideAllContent();
    // Show the account details card by default
    document.getElementById("accountdetails").style.display = "block";
    
    // Add event listener to close the sidebar when content area is clicked
    document.getElementsByClassName("content")[0].addEventListener("click", function() {
        var sidebarWidth = document.getElementById("mySidebar").style.width;
        if (sidebarWidth === "250px") {
            closeNav();
        }
    });
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
    document.getElementById("vendors").style.display = "block";

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

console.log("hello")


    // After 3 seconds, remove the alert message
    setTimeout(function() {
        document.getElementById('depositalert').style.display = 'none';
    }, 3000); 


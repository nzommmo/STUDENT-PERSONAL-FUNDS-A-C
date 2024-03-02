let hidebutton = document.getElementById("btn")
let backbutton = document.getElementById("back")

function hideinfo(){
    var data = document.getElementsByClassName("info")
    for(var i = 0 ; i < data.length; i++){
        data[i].style.display ="none"


    }
    hidebutton.style.display="none"
    backbutton.style.display = "block"
}

btn.addEventListener("click",hideinfo)




function unhideinfo(){
    var data = document.getElementsByClassName("info")

    for(var i = 0 ; i < data.length; i++){
        data[i].style.display = "block"

    }
    backbutton.style.display = "none"
    hidebutton.style.display = "block"
}

back.addEventListener("click",unhideinfo)

/*

let paymentsdiv = document.getElementById("payments")

function display(){
    paymentsdiv.style.display = "block"
}

purchase.addEventListener("click",display)

function undisplay(){
    paymentsdiv.style.display = "none"
}

setTimeout(undisplay,20000)
undisplay()
*/

let displaybuttons =  document.querySelectorAll(".btn")

function display(event){
    
    const targetdivid = event.target.getAttribute('data-target')
    const targetdiv = document.getElementById(targetdivid)
    let paymentsdiv = document.getElementById("payments")
    let withdrawalsdiv = document.getElementById("withdrawals")

    if(targetdiv == payments){
        targetdiv.style.display = "block"
        withdrawalsdiv.style.display = "none"
    } else if (targetdiv == withdrawals){
        targetdiv.style.display = "block"
        paymentsdiv.style.display = "none"
    }


   // targetdiv.style.display ="block"
   
}

displaybuttons.forEach(button => {
    button.addEventListener("click",display)
})

function filter(){
    //to filter dataa
}
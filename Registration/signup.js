let username =  document.getElementById("username")
let password = document.getElementById("password")
let repassword = document.getElementById("repassword")

const pass= password.value 
const repass= repassword.value 

function signup(){
    if(password.value !== repassword.value){
        alert("Passwords do not match")
        
    }
    if (pass.length < 8){
        alert("pasword is too short")

    }
}

signupbtn.addEventListener("click",signup)
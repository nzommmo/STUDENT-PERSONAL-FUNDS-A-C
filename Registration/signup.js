let username =  document.getElementById("username")
let password = document.getElementById("password")
let repassword = document.getElementById("repassword")

const pass= password.value 
const repass= repassword.value 

function signup(){
    if((pass.value ==! repass.value)){
        alert("Passwords do not match")
        
    }
}
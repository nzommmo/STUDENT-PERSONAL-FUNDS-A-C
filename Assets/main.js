let username = document.getElementById("username")
let password = document.getElementById("password")

const user = username.value
const pass = password.value

function login(){
    if (username.value == "ERIC" && password.value =="Kenya2023"){
        window.open("User-Interface/Home.html")
    }else{
        alert("invalid username or passowrd")
    }
}

logbtn.addEventListener("click",login)

function signup(){
    window.open("Registration/signup.html")
}

signbtn.addEventListener("click",signup)
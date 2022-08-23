var regEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var regPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
function closeMenu(){
      document.getElementById("navLinks").style.right="-200px";
}
function openMenu(){
      document.getElementById("navLinks").style.right="0";
}
function validateLogin(){
  if(document.form1.email.value==""){
    alert("Email field cannot be empty!");
    return false;
  }
    if(document.form1.password.value==""){
      alert("Password field cannot be empty!");
      return false;
    }
  }
function validateRegister(){
  if(document.registerForm.email.value==""||!document.registerForm.email.value.match(regEmail)){
    alert("Email field cannot be empty/Invalid email!");
    return false;
  }
  if(document.registerForm.password.value==""||!document.registerForm.password.value.match(regPass)){
    alert("Password field cannot be empty! Invalid password");
    return false;
  }
  if(document.registerForm.cpassword.value==""){
    alert("Confirm password field cannot be empty!");
    return false;
  }
}
function validateOrderForm(){
  var fullName = document.formOrder.fullName.value;
  var cellNo  = document.formOrder.cell.value;
  var email = document.formOrder.email.value;
  var streetField = document.formOrder.street.value;
  var cityField = document.formOrder.city.value;
  var zipField = document.formOrder.zip-code.value;
  var cardHolderField = document.formOrder.cardHolder.value;
  var cardNumberField = document.formOrder.cardNumber.value;
  var expiryDateField = document.formOrder.expiryDate.value;
  var cvvField = document.formOrder.cvv.value;
  if (fullName==""){
    alert("Full name field cannot be empty!");
    return false;
  }
  if (cellNo=="" ||cellNo.length<10){
    alert("cell field cannot be empty or less than 10 digits!");
    return false;
  }
  if (email==""||!email.match(regEmail)){
    alert("email field cannot be empty/Invalid email!");
    return false;
  }
  if (streetField==""){
    alert("street field cannot be empty!");
    return false;
  }
  if (cityField==""){
    alert("city field cannot be empty!");
    return false;
  }
  if (zipField=="" ||isNaN(zipField)||zipField.length!=4){
    alert("zip code field cannot be empty/Invalid Zip Code!");
    return false;
  }
  if (cardHolderField==""){
    alert("card holder field cannot be empty!");
    return false;
  }
  if (cardNumberField==""){
    alert("card number field cannot be empty!");
    return false;
  }
  if (expiryDateField==""){
    alert("expiry date field cannot be empty!");
    return false;
  }
  if (cvvField==""){
    alert("cvv field cannot be empty!");
    return false;
  }
  return true;
}

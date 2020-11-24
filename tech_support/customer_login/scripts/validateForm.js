function validateForm() {

    var flag = true;
    var email = document.getElementById('email');


    if (email.value == "") {
        alert('Please enter all the fields !');
        flag = false;
    }

    return flag;


}

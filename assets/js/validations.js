function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function allLetter(inputtxt){
    var letters = /^[A-Z][a-z]+('[a-z]+|([- ][A-Z][a-z]+))? [A-Z][a-z]+$/;
    if(inputtxt.match(letters)) {
        return true;
    }
    return false;
}

function mobileNum(inputtxt){

    var letters = "";
    var contactlen = inputtxt.length;

    if (inputtxt.charAt(0) === '+'){

        if (contactlen > 13 || contactlen < 13){
            return false;
        }

        letters = /^(\+63-|\+63|0)?\d{10}$/;
    }else if(inputtxt.charAt(0) === '0'){

        if (contactlen > 11 || contactlen < 11){
            return false;
        }

        letters = /^(\+63-|\+63|0)?\d{11}$/;
    }else{
        return false;
    }

    if(inputtxt.match(letters)) {
        return true;
    }
    return false;
}

function alphanumeric(inputtxt){
  var letterNumber = /^[0-9a-zA-Z]+$/;
  if(inputtxt.match(letterNumber)){
    return true;
  }
  return false;
}

function allNumeric(inputtxt){
  var number = /^[0-9]+$/;
  if(inputtxt.match(number)) {
    return true;
  }
  return false;
}

function passwordStrength(password){
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");

    var strengthStatus = "";
    var strengthIndicator = 0;

    if (password==0) {
        strengthStatus = "Type Password";
        strengthIndicator = 1;
    } else if (false == enoughRegex.test(password)) {
        strengthStatus = "More Characters for your password";
        strengthIndicator = 2;
    } else if (strongRegex.test(password)) {
        strengthStatus = "<span style='color:green'>Password is Strong!</span>";
        strengthIndicator = 3;
    } else if (mediumRegex.test(password)) {
        strengthStatus = "<span style='color:orange'>Password is Medium!</span>";
        strengthIndicator = 4;
    } else {
        strengthStatus = "<span style='color:red'>Password is Weak!</span>";
        strengthIndicator = 5;
    }

    var strength = [strengthIndicator, strengthStatus];

    return strength;
}
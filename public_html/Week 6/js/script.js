function validate(form){
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
    //Technically this check isn't necessary since we're not using it across different forms, but
    //it's to show an example of how you can check for a property so you can reuse a validate function for similar
    //forms.
    errors = [];
    if(form.hasOwnProperty("account_number") && form.hasOwnProperty("account_type")){
        if (form.account_number.value == null ||
            form.account_number.value == undefined ||
            form.account_number.value.length == 0) {
            errors.push("Account number must not be empty");
        }
        if (form.account_type.value == null ||
            form.account_type.value == undefined ||
            form.account_type.value.length == 0 || form.account_type.value < 0) {
            errors.push("Account type has not been properly indicated");
        }
    }
    if(errors.length > 0){
        alert(errors);
        return false;//prevent form submission
    }
    return  true;//allow form submission
}
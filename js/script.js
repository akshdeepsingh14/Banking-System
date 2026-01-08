// Confirm before actions (deposit, withdraw, logout)
function confirmAction(message) {
    return confirm(message);
}

// Logout confirmation
function confirmLogout() {
    return confirm("Are you sure you want to logout?");
}

// Password match validation (Register)
function validateForm() {
    let password = document.querySelector('input[name="password"]');
    let confirm  = document.querySelector('input[name="confirm_password"]');

    if (password && confirm && password.value !== confirm.value) {
        alert("Passwords do not match");
        return false;
    }
    return true;
}

// Age validation (Register)
function validateAge() {
    let dobInput = document.querySelector('input[name="dob"]');

    if (!dobInput || !dobInput.value) {
        alert("Please select your date of birth");
        return false;
    }

    let birthDate = new Date(dobInput.value);
    let today = new Date();

    let age = today.getFullYear() - birthDate.getFullYear();
    let monthDiff = today.getMonth() - birthDate.getMonth();

    if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < birthDate.getDate())
    ) {
        age--;
    }

    if (age < 18) {
        alert("You must be 18 years or older to create a bank account");
        return false;
    }

    return true;
}

// Balance highlight (optional UI effect)
window.onload = function () {
    let balance = document.getElementById("balance");
    if (balance) {
        balance.style.color = "green";
        balance.style.fontWeight = "bold";
    }
};

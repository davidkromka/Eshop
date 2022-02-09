$(document).ready(function () {
    var stepper = new Stepper($('.bs-stepper')[0]);
    Array.from(document.getElementsByClassName("btnNext")).forEach(button => button.addEventListener("click", () => { stepper.next(); }));
    Array.from(document.getElementsByClassName("btnPrev")).forEach(button => button.addEventListener("click", () => { stepper.previous(); }));

    var countryDropdown = document.getElementById("personalInfoCountry");
    Array.from(document.getElementsByClassName("dropdown-item country")).forEach(option => option.addEventListener("click", () => countryDropdown.innerHTML = option.innerHTML));

    var countryDropdown2 = document.getElementById("personalInfoCountry2");
    Array.from(document.getElementsByClassName("dropdown-item country2")).forEach(option => option.addEventListener("click", () => countryDropdown2.innerHTML = option.innerHTML));

    var paymentFee = document.getElementById("paymentFee");
    Array.from(document.getElementsByClassName("paymentRadio")).forEach(radio =>
    {
        if (radio.checked == true)
            paymentFee.innerHTML = "Platba:  +" + document.getElementById(radio.id.replace("radio", "price")).innerHTML;
        
        radio.addEventListener("click", (e) =>
        {
            var selectedPrice = document.getElementById(e.target.id.replace("radio", "price")).innerHTML;
            paymentFee.innerHTML = "Platba:  +" + selectedPrice;
        })
    });

    var deliveryFee = document.getElementById("deliveryFee");
    Array.from(document.getElementsByClassName("deliveryRadio")).forEach(radio =>
    {
        if (radio.checked == true)
            deliveryFee.innerHTML = "Doprava:  +" + document.getElementById(radio.id.replace("radio", "price")).innerHTML;
        radio.addEventListener("click", (e) =>
        {
            var selectedPrice = document.getElementById(e.target.id.replace("radio", "price")).innerHTML;
            deliveryFee.innerHTML = "Doprava:  +" + selectedPrice;
        })
    });
});

$(document).ready(() =>
{
    var Content =         document.getElementById('login_register');
    var LoginContent =    document.getElementById('hidden_login').innerHTML;
    var RegisterContent = document.getElementById('hidden_register').innerHTML;

    var LoginButton =    document.getElementById('login_choice');
    var RegisterButton = document.getElementById('register_choice');

    Content.innerHTML = LoginContent;

    var LoginUnderline =    document.getElementById('login_underline');
    var RegisterUnderline = document.getElementById('register_underline')
    var Underline = document.createElement("hr");
    Underline.innerHTML = "<hr style=\"margin: 0px; background: #000000\">";

    LoginUnderline.appendChild(Underline);

    LoginButton.addEventListener('click', () =>
    {
        try { LoginUnderline.removeChild(Underline); }
        catch { }
        RegisterUnderline.removeChild(Underline);

        LoginUnderline.appendChild(Underline);

        Content.innerHTML = LoginContent;
    });

    RegisterButton.addEventListener('click', () =>
    {
        try { RegisterUnderline.removeChild(Underline); }
        catch { }
        LoginUnderline.removeChild(Underline);

        RegisterUnderline.appendChild(Underline);

        Content.innerHTML = RegisterContent;
    });
});

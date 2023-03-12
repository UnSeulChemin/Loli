/* Register, Comfirm Password */
$("#register").on('submit', function()
{
    var plainPassword = $("#registration_form_plainPassword").val();
    var verifPass = $("#verif_pass").val();

    if (plainPassword != verifPass)
    {
        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }
})

/* Profil, Comfirm Password */
$("#profil_password").on('submit', function()
{
    var profilPlainPassword = $("#user_password_form_plainPassword").val();
    var profilVerifPass = $("#profil_verif_pass").val();

    if (profilPlainPassword != profilVerifPass)
    {
        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }
})
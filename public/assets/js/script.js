/* Register, Comfirm Password */
$("#register").on('submit', function()
{
    var plainPassword = $("#registration_form_plainPassword").val();
    var verifPass = $("#verif_pass").val();

    if (plainPassword != verifPass)
    {
        $("#register_flash").css('display', 'none');

        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }

    else
    {
        $("#register_flash").css('display', 'block');

        return true;
    }
})
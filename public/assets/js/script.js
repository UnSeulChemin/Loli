/* Register, Comfirm Password */
$("#register").on('submit', function()
{
    var plainPassword = $("#registration_form_plainPassword").val();
    var verifPass = $("#verif-pass").val();

    if (plainPassword != verifPass)
    {
        $('.pass-verif').css('display', 'block');
        $('.pass-verif-msg').html('Password doesn\'t match.');

        return false;
    }
})
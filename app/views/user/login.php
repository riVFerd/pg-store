<?php
require 'form.html';
?>

<script>
    $(document).ready(function () {
        $('#signupButton').hide();
        $('#userEmail').hide();
        $('#formTitle').text('Login');

        $('#loginButton').click(function () {
            $.ajax({
                url: '/user/login/create_session',
                type: 'POST',
                data: {
                    user_name: $('#userName').val(),
                    user_pass: $('#userPass').val()
                },
                success: function (response) {
                    if (response === 'true') {
                        alert('Login Success!');
                        window.location.href = '/order';
                        return true;
                    }
                    alert(response);
                }
            });
        });
    });
</script>
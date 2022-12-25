<?php
require 'form.html';
?>

<script>
    $(document).ready(function () {
        $('#loginButton').hide();
        $('#signupButton').click(function () {
            $.ajax({
                url: '/user/insert',
                type: 'POST',
                data: {
                    user_name: $('#userName').val(),
                    user_email: $('#userEmail').val(),
                    user_pass: $('#userPass').val()
                },
                success: function (response) {
                    if (response !== 'false') {
                        alert(response);
                        $.ajax({
                            url: '/user/login/create_session',
                            type: 'POST',
                            data: {
                                user_name: $('#userName').val(),
                                user_pass: $('#userPass').val()
                            },
                            success: function (response) {
                                if (response === 'true') {
                                    window.location.href = '/order';
                                    return true;
                                }
                                alert(response);
                            }
                        });
                        return true;
                    }
                    alert('Username was taken!');
                }
            });
        });
    });
</script>
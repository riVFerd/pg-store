<!--footer-->
<div class="container-fluid bg-secondary pt-5">
    <div class="row text-center mb-3">
        <div class="col">
            <img style="max-height: 4rem" src="app/views/home/img/pgbee.png" alt="logo">
        </div>
    </div>
    <div class="row justify-content-center mb-3">
        <div class="col-1 text-center px-0">
            <img src="app/views/home/img/ig.png" onerror="this.src='../app/views/home/img/ig.png'"
                 class="c-footer-icon"></div>
        <div class="col-1 text-center px-0">
            <img src="app/views/home/img/weibo.png" onerror="this.src='../app/views/home/img/weibo.png'"
                 class="c-footer-icon"></div>
        <div class="col-1 text-center px-0">
            <img src="app/views/home/img/fb.png" onerror="this.src='../app/views/home/img/fb.png'"
                 class="c-footer-icon"></div>
    </div>
    <div class="row">
        <div class="col">
            <p class="text-center">© 2022 PG Bee. All rights reserved.</p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

    $(document).ready(function () {
        $('#logoutButton').click(function () {
            $.ajax({
                url: '/user/login/delete_session',
                type: 'POST',
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });
        });
    });
</script>
</body>
</html>
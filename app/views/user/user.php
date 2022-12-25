<body>
<div class="container min-vh-100">
    <div class="row">
        <div class="col-md-12">
            <div class="container d-flex flex-row align-items-center mt-4">
                <h1>Users</h1>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control w-25" id="inputSearch" placeholder="Search products">
            </div>
            <table class="table table-responsive table-striped text-center">
                <thead>
                <tr>
                    <th class="col-4">Username</th>
                    <th class="col-4">Email</th>
                    <th class="col-4">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="col-4"><?= $user['user_name']; ?></td>
                        <td class="col-4"><?= $user['user_email']; ?></td>
                        <td class="col-4">
                            <a onclick="deleteUser(<?= $user['user_id'] ?>)" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row justify-content-center mb-5">
                <a href="/order" class="btn btn-secondary w-25 mt-2">Back</a>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteUser(id) {
        if (confirm('Are you sure want to delete this user?')) {
            $.ajax({
                url: '/user/delete',
                type: 'POST',
                data: {
                    user_id: id
                },
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });
        }
    }
</script>
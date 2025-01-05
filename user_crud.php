<?php
require_once 'db_connection.php';

// Insert User
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $insertQuery = "INSERT INTO Users (name, username, email) VALUES (?, ?, ?)";
    $params = array($name, $username, $email);
    $stmt = sqlsrv_query($conn, $insertQuery, $params);

    if ($stmt) {
        header("Location: user_crud.php?msg=inserted");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Edit User
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editQuery = "SELECT * FROM Users WHERE id = ?";
    $stmt = sqlsrv_query($conn, $editQuery, array($id));
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
}

// Update User
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE Users SET name = ?, username = ?, email = ? WHERE id = ?";
    $params = array($name, $username, $email, $id);
    $stmt = sqlsrv_query($conn, $updateQuery, $params);

    if ($stmt) {
        header("Location: user_crud.php?msg=updated");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteQuery = "DELETE FROM Users WHERE id = ?";
    $stmt = sqlsrv_query($conn, $deleteQuery, array($id));

    if ($stmt) {
        header("Location: user_crud.php?msg=deleted");
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Fetch all users for display
$selectQuery = "SELECT * FROM Users ORDER BY name";
$users = sqlsrv_query($conn, $selectQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User CRUD Operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center">Manage Users</h3>

    <!-- Success message -->
    <p class="text-center">
        <?php
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 'inserted') {
                echo "User inserted successfully!";
            } elseif ($_GET['msg'] == 'updated') {
                echo "User updated successfully!";
            } elseif ($_GET['msg'] == 'deleted') {
                echo "User deleted successfully!";
            }
        }
        ?>
    </p>

    <!-- Add or Edit User Form -->
    <form action="user_crud.php" method="post">
        <?php if (isset($user)): ?>
            <h4>Edit User</h4>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <?php else: ?>
            <h4>Add New User</h4>
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo isset($user) ? $user['name'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo isset($user) ? $user['username'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($user) ? $user['email'] : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="<?php echo isset($user) ? 'update' : 'submit'; ?>">
            <?php echo isset($user) ? 'Update' : 'Add'; ?> User
        </button>
    </form>

    <hr>

    <!-- Displaying Users -->
    <h4 class="text-center">Users List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = sqlsrv_fetch_array($users, SQLSRV_FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="user_crud.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="user_crud.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

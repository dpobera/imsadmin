<!DOCTYPE html>
<html>
<head>
<title>Selecting Rows from MySQL Table using checkbox PHP, MySQLi</title>
</head>
<body>
	<h2>Select User:</h2>
	<div>
	<form method="POST">
	<table border="1">
		<thead>
			<th></th>
			<th>Username</th>
			<th>Password</th>
			<th>Full Name</th>
		</thead>
		<tbody>
			
			<?php
			include('conn.php');
				$query=mysqli_query($conn,"select * from `user`");
				while($row=mysqli_fetch_array($query)){
					?>
					<tr>
						<td><input type="checkbox" value="<?php echo $row['userid']; ?>" name="id[]"></td>
						<td><?php echo $row['username']; ?></td>
						<td><?php echo $row['password']; ?></td>
						<td><?php echo $row['fullname']; ?></td>
					</tr>
					<?php
				}
			?>
			
		</tbody>
	</table>
	<br>
	<input type="submit" name="submit" value="Submit">
	</form>
	</div>
	<div>
		<h2>You Selected:</h2>
		<?php
			if (isset($_POST['submit'])){
				foreach ($_POST['id'] as $id):
				
				$sq=mysqli_query($conn,"select * from `user` where userid='$id'");
				$srow=mysqli_fetch_array($sq);
				echo $srow['fullname']. "<br>";
				
				endforeach;
			}
		?>
	</div>
</body>
</html>
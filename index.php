<?php include 'includes/login.php';?>
<?php include 'includes/header.php'; ?>
	<div class="d-flex mt-5 justify-content-center">
		<div class="card bg-secondary text-white">
			<div class="card-header">Login your Account</div>
			<div class="card-body">
				<form method="POST" class="was-validated">
					<div class="mb-3 mt-3">
						<label for="username">Username:</label>
						<input type="username" class="form-control" id="username" placeholder="Enter your Username" name="username">
					</div>
					<div class="mb-3">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" placeholder="Enter your Password" name="password">
					</div>
					<div class="d-grid gap-3">
						<button type="submit" class="btn btn-success btn-block">Submit</button>
					</div>
				</form>	
			</div>

		</div>

	</div>
</body>
</html>
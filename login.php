<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Sign In | Capytech Inventory</title>

    <link href="styles/css/bootstrap.min.css" rel="stylesheet">
	<link href="styles/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

                        <?php 
                        if(!empty($_SESSION["login_err"])){
                            echo '<div role="alert" class="alert alert-danger">' . $_SESSION["login_err"] . '</div>';
                        }        
                        ?>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<form action="lib/login.php" method="post" autocomplete="off">
										<div class="mb-3">
											<label class="form-label">Username</label>
											<input type="text" name="username" placeholder="Enter your username" class="form-control-lg form-control <?php echo (!empty($_SESSION["username_err"])) ? 'is-invalid' : ''; ?>">
                                            <span class="invalid-feedback"><?php echo $_SESSION["username_err"]; ?></span>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input autocomplete="new-password" type="password" name="password" placeholder="Enter your password" class="form-control-lg form-control <?php echo (!empty($_SESSION["password_err"])) ? 'is-invalid' : ''; ?>">
                                            <span class="invalid-feedback"><?php echo $_SESSION["password_err"] ?></span>
											<small>
												<a href="index.html">Forgot password?</a>
											</small>
										</div>
										<div>
											<label class="form-check">
												<input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
												<span class="form-check-label">
												Remember me next time
												</span>
          									</label>
										</div>
										<div class="text-center mt-3">
                                            <input type="submit" class="btn btn-lg btn-primary" value="Sign in">
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="styles/js/app.js"></script>

</body>

</html>
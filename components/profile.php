<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Profile</strong></h1>

		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill justify-content-between">
                    <div class="card d-flex justify-content-between">
                        <div class="card-body text-center">
                        <?php
                            $employee = $_SESSION['username'];
                            $info = "SELECT * from employees WHERE username = '$employee' ";
							$getInfo = mysqli_query($db, $info);
                            if(mysqli_num_rows($getInfo)){
                                while ($emp = mysqli_fetch_assoc($getInfo)) {
                                    $name = $emp['firstname']." ".$emp['lastname'];
                                    $first = $emp['firstname'];
                                    $last = $emp['lastname'];
                                }
                            }

                        ?>
						    <img src="styles/img/avatars/capyphoto.png" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="300" height="300">
							<h5 class="card-title mb-0"><?php echo $name; ?></h5>
                            <div class="text-muted mb-2">Employee</div>
                            <br>
                            <form action="lib/update.php" method="post" autocomplete="off">
                            <div class="row mb-3">
                                <div class="col">
                                    <input required type="text" class="form-control" placeholder="First Name" name="firstName" id="firstName" value="<?php echo $first; ?>">
                                </div>
                                <div class="col">
                                    <input required type="text" class="form-control" placeholder="Last Name" name="lastName" id="lastName" value="<?php echo $last; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <input disabled type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?php echo $employee; ?>">
                                </div>
                                <div class="col">
                                    <input required type="password" class="form-control" placeholder="Password" name="password" id="password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" class="btn btn-primary" name="submitProfile" value="Save">
                                </div>
                            </div>
                            </form>
					    </div>
                    </div>
				</div>
			</div>			
		</div>
	</div>
</main>
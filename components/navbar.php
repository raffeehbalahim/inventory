<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
    </a>

	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<?php 
				if($_SESSION["user_type"] == 1){ 
					//$get_requestCount = "SELECT COUNT(*) FROM requests WHERE checked = 0";
					//$count = mysqli_query($db, $get_requestCount);
					$result = mysqli_query($db, "SELECT COUNT(*) as total FROM requests WHERE checked = 0");
					$data = mysqli_fetch_assoc($result);
					$count = $data['total'];
			?>
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown" onclick="viewedNotif()">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<?php if($count > 0){ ?>
						<span class="indicator" id="notifCount"><?php echo $count; ?></span>
						<?php } ?>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
						<?php echo $count; ?> New Requests
					</div>
					<div class="list-group">
					<?php 
						$get_request = "SELECT * FROM requests WHERE status = 0 ORDER BY checked";
						$result_request = mysqli_query($db, $get_request);
						if (mysqli_num_rows($result_request) > 0) {
							while ($request = mysqli_fetch_assoc($result_request)) {
					?>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<?php if($request['checked']==0){?>
									<i class="text-danger" data-feather="alert-circle"></i>
									<?php } ?>
								</div>
								<div class="col-10">
									<div class="text-dark">Request</div>
									<?php 
										$id = $request['userid'];
										$get_user = "SELECT * FROM users WHERE id = '$id'";
										$result_user = mysqli_query($db, $get_user);
										if (mysqli_num_rows($result_request) > 0) {
											while ($user = mysqli_fetch_assoc($result_user)) {
												$user_name = $user['username'];
											}
										}
										$get_users = "SELECT * FROM employees WHERE username = '$user_name'";
										$result_users = mysqli_query($db, $get_users);
										if (mysqli_num_rows($result_request) > 0) {
											while ($users = mysqli_fetch_assoc($result_users)) {
												$name = $users['firstname']." ".$users['lastname'];
											}
										}
										$item_id = $request['itemid'];
										$get_item = "SELECT * FROM peripherals WHERE component_id = '$item_id'";
										$result_item = mysqli_query($db, $get_item);
										if (mysqli_num_rows($result_request) > 0) {
											while ($item = mysqli_fetch_assoc($result_item)) {
												$item_name = $item['brand']." - ".$item['unit'];
											}
										}
									?>
									<div class="text-muted small mt-1"><?php echo $name ?> requests for the item <?php echo $item_name ?>.</div>
									<!--<div class="text-muted small mt-1">30m ago</div> -->
								</div>
							</div>
						</a>
					<?php	}
						}
					?>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li>
			<?php 
					} else {
						$iduser = $_SESSION['id'];
						$result = mysqli_query($db, "SELECT COUNT(*) as total FROM requests WHERE userid = '$iduser' AND user_checked = 0 AND status != 0");
						$data = mysqli_fetch_assoc($result);
						$count = $data['total'];
			?>
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown" onclick="viewedNotifUser()">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<?php if($count > 0){ ?>
						<span class="indicator" id="notifCount"><?php echo $count; ?></span>
						<?php } ?>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
						<?php echo $count; ?> New Notifications
					</div>
					<div class="list-group">
					<?php 
						$get_request = "SELECT * FROM requests WHERE userid = '$iduser' AND status != 0 ORDER BY user_checked";
						$result_request = mysqli_query($db, $get_request);
						if (mysqli_num_rows($result_request) > 0) {
							while ($request = mysqli_fetch_assoc($result_request)) {
								if($request['status']==1){
									$status = "APPROVED";
								} else {
									$status = "DECLINED";
								}
					?>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								
								<div class="col-2">
									<?php if($request['user_checked']==0){?>
									<i class="text-danger" data-feather="alert-circle"></i>
									<?php } ?>
								</div>
								<div class="col-10">
									<div class="text-dark"><?php echo $status ?></div>
									<?php 
										$item_id = $request['itemid'];
										$get_item = "SELECT * FROM peripherals WHERE component_id = '$item_id'";
										$result_item = mysqli_query($db, $get_item);
										if (mysqli_num_rows($result_request) > 0) {
											while ($item = mysqli_fetch_assoc($result_item)) {
												$item_name = $item['brand']." - ".$item['unit'];
											}
										}
									?>
									<div class="text-muted small mt-1">Your request for <?php echo $item_name ?> has been <?php echo $status ?>.</div>
									<!--<div class="text-muted small mt-1">30m ago</div> -->
								</div>
							</div>
						</a>
					<?php	}
						}
					?>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li>
			
			<?php 
					}
			?>
			<!-- <li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="message-square"></i>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
					<div class="dropdown-menu-header">
						<div class="position-relative">
							4 New Messages
						</div>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Vanessa Tucker</div>
									<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
									<div class="text-muted small mt-1">15m ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">William Harris</div>
									<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
									<div class="text-muted small mt-1">2h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Christina Mason</div>
									<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
									<div class="text-muted small mt-1">4h ago</div>
								</div>
							</div>
						</a>
						<a href="#" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
								</div>
								<div class="col-10 ps-2">
									<div class="text-dark">Sharon Lessman</div>
									<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
									<div class="text-muted small mt-1">5h ago</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all messages</a>
					</div>
				</div>
			</li> -->
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="align-middle" data-feather="settings"></i>
				</a>

				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
					<img src="styles/img/avatars/Capyphoto.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?php echo $_SESSION['username'];?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="profile.php"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="lib/logout.php">Log out</a>
				</div>
			</li>
		</ul>
	</div>
</nav>

<script>
	function viewedNotif(){
		document.getElementById("notifCount").style.display = 'none';
		var userType = 1;
		$.ajax({
		method: "POST",
        url: "lib/notif_update.php/adminNotif",
		data: {user_type: userType}
		});
	}
	function viewedNotifUser(){
		document.getElementById("notifCount").style.display = 'none';
		var userType = 2;
		$.ajax({
		method: "POST",
        url: "lib/notif_update.php/adminNotif",
		data: {user_type: userType}
		});
	}
</script>
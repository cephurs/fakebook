<?php
require_once 'config.php';
require_once 'php/Fakebook.php';

$pageTitle = 'Homepage';

$fakebook = new Fakebook();

$friendRequests = $fakebook->getFriendRequests();

// if the user is not logged, redirect to the login page
if (!$fakebook->getLoggedUserId()) {
	header("location: index.php");
}

if (isset($_GET['action']) && isset($_GET['id'])) {
	$action = $_GET['action'];
	$id = $_GET['id'];
	if ($action == 'accept') {
		$fakebook->acceptFriendRequest($id);
		$fakebook->ok(3);
		return;
	} else if ($action == 'refuse') {
		$fakebook->removeFriendRequest($id);
		$fakebook->ok(4);
		return;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.inc.php'; ?>
<body>
	<?php
	$topBarSelectedIcon = 1;
	include 'topbar.inc.php';
	?>
	<div id="container">
		<?php include 'sidebar.inc.php' ?>
		<section id="content">
			<h1 style="margin-top: 0;">Friends requests:</h1>
			<table>
			<?php if (!$friendRequests) {
				echo 'Sorry but there are no friend requests.';
			} ?>
			<?php foreach ($friendRequests as $rid) : ?>
			<tr>
				<td style="width:250px;"><?= $fakebook->getFullName($rid) ?></td>
				<td style="width:60px;"><a href="friend-requests.php?action=accept&id=<?= $rid ?>">Accept</a></td>
				<td style="width:60px;"><a href="friend-requests.php?action=refuse&id=<?= $rid ?>">Refuse</a></td>
			</tr>
			<?php endforeach ?>
			</table>
		</section>
	</div>
</body>
</html>
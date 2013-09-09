<?php
require_once('bootstrap.php');

if (!empty($_POST['actorName'])) {
    $actor = new Actor();
    $actor->name = $_POST['actorName'];
    Actor::save($actor);
} else if (!empty($_GET['actorName'])) {
    $actor = Actor::getActorByName($_GET['actorName']);
}

?>
<form action="" method="POST">
Add Actor Name: <input type="text" name="actorName" />
<input type="submit" value="Add" />
</form>

<form action="" method="GET">
Find Actor Name: <input type="text" name="actorName" />
<input type="submit" value="Search" />
</form>

<?php if (!empty($actor)) : ?>
    Name: <?php echo $actor->name; ?><br />
    Id: <?php echo $actor->id; ?><br />
<?php elseif (!empty($_GET['actorName'])) : ?>
    No actor found by the name of "<?php echo $_GET['actorName']; ?>"<br />
<?php endif; ?>

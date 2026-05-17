<?php

// configuration
$url = 'editnotifwa';
$file = "application/views/backend/bill/message.php";

// check if form has been submitted
if (isset($_POST['text'])) {
    // save the text contents
    file_put_contents($file, $_POST['text']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', $url);
    exit();
}

// read the textfile
$text = file_get_contents($file);

?>
<!-- HTML form -->
<form action="" method="post">
    <textarea name="text" class="form-control mb-2"><?php echo htmlspecialchars($text) ?></textarea>
    <button class="btn btn-success" type="submit">Simpan</button>
    <input type="reset" />
</form>
<?php

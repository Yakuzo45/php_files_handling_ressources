<?php include('inc/head.php'); ?>

<?php
$file = $_GET['file'];
$contenu = file_get_contents($file);
?>

<h1><?php echo basename($file) ?></h1>
<form method="post" action="modify.php?file=<?php echo $_GET['file'] ?>">
    <label for="contenu">Contenu :</label>
    <textarea class="engrand" id="contenu" name="message"><?php echo $contenu ?></textarea>

    <input type="submit" class="btn btn-success" value="Valider"/>
</form>
<form method="post">
    <input type="hidden" name="delete" value="<?php echo $_GET['file'] ?>"/>
    <input type="submit" class="btn btn-danger" value="Supprimer"/>
</form>
<?php

if (isset($_POST['message'])) {
    $fichier = fopen($file, 'w');
    fwrite($fichier, $_POST['message']);
    fclose($fichier);
    header('Location:index.php?dir='. dirname($file));
    exit();
}
?>
<?php include('inc/foot.php'); ?>
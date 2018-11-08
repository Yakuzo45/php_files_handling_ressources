<?php include('inc/head.php'); ?>

<?php

function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}

$url = 'files/';
if (isset($_GET['dir'])) {
    $url = $_GET['dir'];
}

const EXTENSION = ['html','txt'];
$fileManager = new FilesystemIterator($url);

?>
    <div class="row justify-content-center">
<?php
foreach ($fileManager as $file) {
    if (is_dir($file)) {
        echo '<div class="col-sm-12 col-md-6 col-lg-4">
                      <a href="?dir='.$file.'">
                          <div class="card">
                              <img class="card-img-top" src="assets/images/dossier.jpeg" alt="">
                              <div class="card-body">
                                <h5 class="card-title">'.basename($file).'</h5>
                              </div>
                          </div>
                      </a>
                      <form method="POST">
                        <input type="hidden" name="delete" value="'. $file . '"/>
                        <input type="submit" class="btn btn-danger" value="Supprimer"/>
                      </form>
             </div>';

    } elseif (in_array(pathinfo($file,PATHINFO_EXTENSION),EXTENSION)) {
        echo '<div class="col-sm-12 col-md-6 col-lg-4">
                      <a href="modify.php?file='.$file.'">
                          <div class="card">
                              <img class="card-img-top" src="assets/images/fichier.jpg" alt="">
                              <div class="card-body">
                                <h5 class="card-title">'.basename($file).'</h5>
                              </div>
                          </div>
                      </a>
                      <form method="POST">
                        <input type="hidden" name="delete" value="'. $file .'"/>
                        <input type="submit" class="btn btn-danger" value="Supprimer"/>
                      </form>
              </div>';

    }
    if (isset($_POST['delete'])) {
        if (is_dir($_POST['delete'])) {
            rrmdir($_POST['delete']);
        } else {
            unlink($_POST['delete']);
        }
        header('Location:index.php?dir='. dirname($file));
        exit();
    };
}
?>
        </div>

<?php include('inc/foot.php'); ?>
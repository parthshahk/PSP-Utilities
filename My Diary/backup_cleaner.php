<?php
if (file_exists('backup.zip')){
    unlink('backup.zip');
    echo 'Clear';
}else{
    echo 'Nothing to clean';
}
?>
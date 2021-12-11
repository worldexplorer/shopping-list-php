<? require_once "_code.php" ?>
<?

//plog(pr($uprofile));
//plog(pr($_COOKIE));

//moved to _code.php
//if ($unhashed["person"] == 0) redirect("auth.php");

$mmenu_content = hash_by_tpl($unhashed, $mmenu_content);

$title .= ": " . $unhashed["person_ident"] . "";

?>

<? require "_top.php" ?>

<?=$mmenu_content?>


<? require "_bottom.php" ?>

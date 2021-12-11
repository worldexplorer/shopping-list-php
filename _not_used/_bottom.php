<?
plog(pr("\n\r\n\r"));
plog(pr($uprofile, "_bottom:uprofile"));
plog(pr($unhashed, "_bottom:unhashed"));
//plog(pr($_SESSION, "_bottom:_SESSION"));
//plog(pr($_REQUEST, "_bottom:_REQUEST"));
//plog(pr($_SERVER, "_bottom:_SERVER"));
//plog(pr($_COOKIE, "_bottom:_COOKIE"));
?>

<!-- BOTTOM BEGIN -->


<!--p align=right>[<?= round(getmicrotime() - $start_execution_time, 2) ?> sec]</p-->
<? if ($layers_total > 0) echo "<script>layers_total=$layers_total</script>" ?>

<? if ($plog != "") { ?>
<pre><?=$plog?></pre>
<? } ?>


<? if ($alertmsg != "") { ?>
<script>
alert("<?=$alertmsg?>");
</script>
<? } ?>



</body>

</html>

<?php require_once '../../core/includes.php';

$p = new Project;
$p->delete();
header("Location: /");
exit();

<?php
require_once '../PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('disposisi.docx');

$document->setValue('AQUA', 'sadasdasd teaQdasdas asdasdsa');
$document->setValue('SEMPAK', 'Mercury444');
$document->setValue('TESSSS', 'wewaew');


$document->setValue('weekday', date('l'));
$document->setValue('time', date('H:i'));

$document->save('Solarsystem.docx');
?>
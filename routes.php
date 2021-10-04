<?php
use SocymSlim\MVC\controllers\HelloController;
use SocymSlim\MVC\controllers\ChangerController;

$app->any("/sayHello", HelloController::class.":sayHello");
$app->any("/changerForKsc/{pt}/{st}", HelloController::class.":changerForKsc");

$app->any("/goChangerApp/{pt}/{st}[/{fl}]", ChangerController::class.":goChangerApp");
$app->any("/changerApp", ChangerController::class.":changerApp");
$app->any("/showChangerSet/{st}/{vl}/{id}/{ct}", ChangerController::class.":showChangerSet");

$app->any("/showChangerList", ChangerController::class.":showChangerList");
$app->any("/getAllChangersJSON", ChangerController::class.":getAllChangersJSON");

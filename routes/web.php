<?php

foreach (glob(base_path('app/Modules/*/routes/web.php')) as $moduleRoute) {
    require $moduleRoute;
}
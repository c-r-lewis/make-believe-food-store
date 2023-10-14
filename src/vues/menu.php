<?php
/** @var array $onglets */

foreach ($onglets as $onglet) {
    echo '<a href="">' . key($onglet) . '</a>';
}
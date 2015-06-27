<?php

// copy this file to config/local.php
// and this will be your server-specific config (in .gitignore)
// so you may to return any config as you want
// I prefer to keep all environment configs in "env" dir
// and include necessary file from it

return require __DIR__.'/env/prod.php';

<?php

function crearSession($email)
{
    $_SESSION["usuario"] = $email;
}

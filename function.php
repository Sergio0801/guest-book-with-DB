<?php
require "config.php";
require "bd.php";
require "guestbook.php";
$guest = new GuestBook(new Bd());
$guest->init();



<?php
namespace chhcn;

use chhcn;

chhcn\Utils::checkCsrf();

unset($_SESSION['user']);
unset($_SESSION['mail']);
unset($_SESSION['token']);
?>
<script>location='?page=login';</script>
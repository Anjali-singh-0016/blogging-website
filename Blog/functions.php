<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_logged_in($location) {
    if (is_logged_in()) {
        header("Location: $location");
        exit();
    }
}
?>

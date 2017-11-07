<?php
require_once('Models/UserRepository.php');

if (isset($_POST['id']) && isset($_POST['id']) != "") {
    $user_id = $_POST['id'];

    $userRepository = new ProductRepository();
    $userRepository->Delete($user_id);
}

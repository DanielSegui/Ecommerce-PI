<?php
define('USERS_FILE', __DIR__ . '/../data/users.json');

function read_users() {
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, json_encode(['usuaris' => []], JSON_PRETTY_PRINT));
    }
    $data = json_decode(file_get_contents(USERS_FILE), true);
    return $data['usuaris'] ?? [];
}

function write_users($users) {
    $data = ['usuaris' => $users];
    file_put_contents(USERS_FILE, json_encode($data, JSON_PRETTY_PRINT));
}
?>

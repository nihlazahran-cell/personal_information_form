<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST["first_name"];
    $last_name  = $_POST["last_name"];
    $nic        = $_POST["nic"];
    $dob        = $_POST["dob"];

    $motivation = isset($_POST["motivation"])
        ? implode(", ", $_POST["motivation"])
        : "";

    $stmt = $conn->prepare(
        "INSERT INTO personal_info
        (first_name, last_name, nic, dob, motivation)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $first_name,
        $last_name,
        $nic,
        $dob,
        $motivation
    );

    if ($stmt->execute()) {
        $id = $conn->insert_id;

        header("Location: form.php?id=" . $id);
        exit();
    }

    echo "Error saving data";
}
?>
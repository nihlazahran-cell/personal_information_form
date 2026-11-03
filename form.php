<?php
include "db.php";

$data = [
    "first_name" => "",
    "last_name" => "",
    "nic" => "",
    "dob" => "",
    "motivation" => ""
];

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if ($id > 0) {
    $stmt = $conn->prepare(
        "SELECT * FROM personal_info WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    }
}

$selected = explode(", ", $data["motivation"]);

function safe($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Information</title>
</head>

<body>

<h2>My Personal Information</h2>

<form action="save.php" method="POST">

    First Name:
    <input type="text" name="first_name"
    value="<?= safe($data['first_name']) ?>" required>
    <br><br>

    Last Name:
    <input type="text" name="last_name"
    value="<?= safe($data['last_name']) ?>" required>
    <br><br>

    NIC:
    <input type="text" name="nic"
    value="<?= safe($data['nic']) ?>" required>
    <br><br>

    Date of Birth:
    <input type="date" name="dob"
    value="<?= safe($data['dob']) ?>" required>
    <br><br>

    <h3>Motivation</h3>

    <input type="checkbox" name="motivation[]"
    value="To gain knowledge"
    <?= in_array("To gain knowledge", $selected) ? "checked" : "" ?>>
    To gain knowledge
    <br>

    <input type="checkbox" name="motivation[]"
    value="To build a career"
    <?= in_array("To build a career", $selected) ? "checked" : "" ?>>
    To build a career
    <br>

    <input type="checkbox" name="motivation[]"
    value="To help the community"
    <?= in_array("To help the community", $selected) ? "checked" : "" ?>>
    To help the community
    <br><br>

    <button type="submit">Save Information</button>

</form>

</body>
</html> 
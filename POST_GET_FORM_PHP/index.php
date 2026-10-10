
<?php
session_start();

class Registration {
    public $name;
    public $email;
    public $mobile;
    public $governorate;
    public $track;
    public $skills;
    public $message;
}

$governorates = ["Amman", "Irbid", "Aqaba", "Zarqa"];
$tracks = ["Full Stack", "Frontend", "Backend"];
$availableSkills = ["HTML", "CSS", "JavaScript"];

$name = "";
$email = "";
$mobile = "";
$governorate = "";
$track = "";
$skills = [];
$message = "";
$errors = [];
$registration = null;

function h($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        "UTF-8"
    );
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mobile = trim($_POST["mobile"] ?? "");
    $governorate = $_POST["governorate"] ?? "";
    $track = $_POST["track"] ?? "";
    $message = trim($_POST["message"] ?? "");
    $submittedSkills = $_POST["skills"] ?? [];

    if (is_array($submittedSkills)) {
        $skills = array_values(
            array_intersect($submittedSkills, $availableSkills)
        );
    }

    $agree = isset($_POST["agree"]);

    if ($name === "") {
        $errors["name"] = "Full Name is required.";
    }

    if ($email === "") {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email address.";
    }

    if ($mobile === "") {
        $errors["mobile"] = "Mobile is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors["mobile"] = "Enter a 10-digit mobile number.";
    }

    if (!in_array($governorate, $governorates, true)) {
        $errors["governorate"] = "Choose a governorate.";
    }

    if (!in_array($track, $tracks, true)) {
        $errors["track"] = "Choose a track.";
    }

    if (empty($skills)) {
        $errors["skills"] = "Choose at least one skill.";
    }

    if (!$agree) {
        $errors["agree"] = "You must accept the terms.";
    }

    if (empty($errors)) {

        $registration = new Registration();

        $registration->name = $name;
        $registration->email = $email;
        $registration->mobile = $mobile;
        $registration->governorate = $governorate;
        $registration->track = $track;
        $registration->skills = $skills;
        $registration->message = $message;

        $_SESSION["registration"] = $registration;

        setcookie(
            "saved_track",
            $track,
            time() + (86400 * 30),
            "/"
        );

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if ($registration !== null): ?>

    <h1>Registration Successful!</h1>

    <h2>Your Information</h2>

    <p><strong>Full Name:</strong> <?= h($registration->name) ?></p>
    <p><strong>Email:</strong> <?= h($registration->email) ?></p>
    <p><strong>Mobile:</strong> <?= h($registration->mobile) ?></p>
    <p><strong>Governorate:</strong> <?= h($registration->governorate) ?></p>
    <p><strong>Track:</strong> <?= h($registration->track) ?></p>
    <p><strong>Skills:</strong> <?= h(implode(", ", $registration->skills)) ?></p>
    <p><strong>Message:</strong> <?= h($registration->message) ?></p>

    <p><a href="profile.php">View Profile Page</a></p>
    <p><a href="index.php">Back to Registration</a></p>

<?php else: ?>

<form action="index.php" method="post">

    <label for="name">Full Name</label>
    <input type="text" id="name" name="name"
           value="<?= h($name) ?>">
    <span class="error"><?= h($errors["name"] ?? "") ?></span>

    <label for="email">Email</label>
    <input type="email" id="email" name="email"
           value="<?= h($email) ?>">
    <span class="error"><?= h($errors["email"] ?? "") ?></span>

    <label for="mobile">Mobile</label>
    <input type="tel" id="mobile" name="mobile"
           placeholder="0791234567"
           value="<?= h($mobile) ?>">
    <span class="error"><?= h($errors["mobile"] ?? "") ?></span>

    <label for="governorate">Governorate</label>
    <select id="governorate" name="governorate">
        <option value="">Choose a governorate</option>

        <?php foreach ($governorates as $g): ?>
            <option value="<?= h($g) ?>"
                <?= $governorate === $g ? "selected" : "" ?>>
                <?= h($g) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <span class="error"><?= h($errors["governorate"] ?? "") ?></span>

    <label>Track</label>

    <?php foreach ($tracks as $t): ?>
        <label class="inline">
            <input type="radio" name="track"
                   value="<?= h($t) ?>"
                   <?= $track === $t ? "checked" : "" ?>>
            <?= h($t) ?>
        </label>
    <?php endforeach; ?>

    <span class="error"><?= h($errors["track"] ?? "") ?></span>

    <label>Skills you already have</label>

    <?php foreach ($availableSkills as $skill): ?>
        <label class="inline">
            <input type="checkbox" name="skills[]"
                   value="<?= h($skill) ?>"
                   <?= in_array($skill, $skills, true) ? "checked" : "" ?>>
            <?= h($skill) ?>
        </label>
    <?php endforeach; ?>

    <span class="error"><?= h($errors["skills"] ?? "") ?></span>

    <label for="message">Why do you want to join? (optional)</label>
    <textarea id="message" name="message" rows="4"><?= h($message) ?></textarea>

    <label class="inline terms">
        <input type="checkbox" name="agree" value="yes"
               <?= isset($_POST["agree"]) && $agree ? "checked" : "" ?>>
        I agree to the academy terms
    </label>
    <span class="error"><?= h($errors["agree"] ?? "") ?></span>

    <button type="submit">Register</button>

</form>

<?php endif; ?>

</body>
</html>

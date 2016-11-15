<?php


use QuickPdo\QuickPdo;
require_once "../init.php";


//--------------------------------------------
// CONFIG
//--------------------------------------------
$table = "users"; // in which table are we going to insert the newly created users
$use_forgotten_password = true;
$successUrl = "/";


//--------------------------------------------
// SCRIPT --
//--------------------------------------------
$formValidated = false;
$errorStateEmailExists = "";
$email = "";
$password = "";

$fieldsToSelect = "id, pseudo, url_photo";
$onConnexionAfter = function (array $item) {
    User::connect($item);
};

if (
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    $email = (string)$_POST['email'];
    $password = (string)$_POST['password'];
    $res = QuickPdo::fetch("select $fieldsToSelect from  $table  where email=:email and password=:password", [
        'email' => $email,
        'password' => $password,
    ]);
    if (false !== $res) {
        $formValidated = true;
        call_user_func($onConnexionAfter, $res);


    } else {
        $errorStateEmailExists = "activated";
    }
}

?>

<?php if (false === $formValidated): ?>
    <h1 class="centered block">Sign In</h1>
    <div class="centered block">
        <form id="form-connection" action="#posted" method="post" class="form connection-form">
            <p class="error <?php echo $errorStateEmailExists; ?>" id="error-email2">This email/password is not
                registered
                in our database</p>
            <label>
                <span>Email</span> <input id="input-email" type="text" name="email"
                                          value="<?php echo htmlspecialchars($email); ?>">
            </label>
            <label>
                <span>Password</span> <input id="input-password" type="password" name="password"
                                             value="<?php echo htmlspecialchars($password); ?>">
            </label>
            <div class="submit">
                <input id="input-submit" class="input-submit" type="submit" value="Sign In">
            </div>
        </form>
        <?php if($use_forgotten_password): ?>
        <div class="forgotten_password">
            <a href="<?php echo url("/forgotten_password"); ?>">Forgotten password?</a>
        </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <script>
        window.location.href = "<?php echo $successUrl; ?>";
    </script>

<?php endif; ?>



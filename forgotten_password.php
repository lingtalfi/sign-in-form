<?php


use QuickPdo\QuickPdo;


require_once "../init.php";




//--------------------------------------------
// CONFIG
//--------------------------------------------
$table = "users";
$mode = 'resend'; // resend | reset (only resend is implemented for now)

/**
 * This callback below sends the email to the user.
 * In order to use it as is, you need to:
 *
 * - have a WEBSITE_NAME constant defined
 * -  have a sendMailTo function installed (here is the implementation used in the example https://github.com/lingtalfi/send-mail-to)
 *
 */
$onConnexionAfter = function (array $item) {
    require_once __DIR__ . "/../vendor/autoload.php";
    $subject = WEBSITE_NAME . ": Forgotten password";
    $message = <<<EOL
Hi $item[pseudo],
you have request your password, so here it is: $item[password]
EOL;
    sendMailTo($subject, $message, $item['email']);
};


//--------------------------------------------
// SCRIPT --
//--------------------------------------------
$formValidated = false;
$errorStateEntryNotFound = "";
$email = "";
$password = "";


if (
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    $email = (string)$_POST['email'];
    $password = (string)$_POST['password'];
    $res = QuickPdo::fetch("select id, email, pseudo from  $table  where email=:email and password=:password", [
        'email' => $email,
        'password' => $password,
    ]);
    if (false !== $res) {
        $formValidated = true;
        $res['password'] = $password;
        call_user_func($onConnexionAfter, $res);
    } else {
        $errorStateEntryNotFound = "activated";
    }
}

?>

    <h1 class="centered block">Forgotten Password</h1>
    <div class="centered block">
        <?php if (false === $formValidated): ?>
            <form id="form-connection" action="#posted" method="post" class="form connection-form">
                <p class="error <?php echo $errorStateEntryNotFound; ?>" id="error-email2">This email/password is not
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
                    <input id="input-submit" class="input-submit" type="submit" value="Resend my password">
                </div>
            </form>

        <?php else: ?>
            Your password has been resent to <?php echo $email; ?>
        <?php endif; ?>
    </div>

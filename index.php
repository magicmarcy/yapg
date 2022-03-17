<?php
  require('Options.php');
  
  $options = new Options(16, 0, 0);
  
  // We want here that after generating a password, the information is retained so that a new 
  // one with the same properties can be generated directly afterwards.
  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['anzahlZeichen'])) {
      $options->anzahlZeichen = $_POST['anzahlZeichen'];
    }

    if (isset($_POST['mitZahlen']) == '1') {
      $options->mitZahlen = '1';
    }

    if (isset($_POST['mitSonderzeichen']) == '1') {
      $options->mitSonderzeichen = '1';
    }
  }
;?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-language" content="de">
    <meta name="author" content="magicmarcy">
    <meta name="publisher" content="magicmarcy">
    <meta name="copyright" content="magicmarcy">
    <meta name="description" content="YAPG | Yet Another Password Generator">
    <meta name="keywords" content="password, security, md5, random, generator, sha1, generator, web, manager, free, php, login, passwort, bootstrap">
    <meta name="page-topic" content="Dienstleistung">
    <meta name="page-type" content="Dienstleistung">
    <meta name="audience" content="Alle">
    <meta name="robots" content="index, nofollow">
    <meta name="DC.Creator" content="magicmarcy">
    <meta name="DC.Publisher" content="magicmarcy">
    <meta name="DC.Rights" content="magicmarcy">
    <meta name="DC.Description" content="YAPG | Yet Another Password Generator">
    <meta name="DC.Language" content="en">
    <title>Yet Another Password Generator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="registration-form">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="form-icon">
                <span><i class="icon icon-key"></i></span>
            </div>
            <div class="welcome-text">
              <h3>Yet Another Password Generator</h3>
              <hr/>
              <p>Secure passwords are more important than ever today and you should follow a few rules. The password should be as long as possible, contain numbers, letters and special characters and preferably not contain any connected words. If you follow these rules, however, it is difficult to come up with such a password.</p>
              <p>Here you can now generate such a password and put it together according to your wishes. It's best to use a password manager, then you don't even have to remember this complex password.</p>
              <p><b>INFO:</b><br/>
              The generated passwords are not stored in any way nor are they available through any history!</p>
            </div>

            <hr/>

            <div class="container">
              <table>
                <tr class="amount-row">
                  <td style="width:45%;"><label for="anzahlZeichen" name="anzahlZeichenLabel">Number of characters:</label></td>
                  <td style="width:20%;"><input type="number" name="anzahlZeichen" min="4" max="32" value="<?php echo $options->anzahlZeichen;?>"/></td>
                  <td style="width:30%;"><small><?php echo Options::CHARACTER_MIN;?> to <?php echo Options::CHARACTER_MAX;?> characters</small></td>
                </tr>
                <tr class="withnumbers-row">
                  <td><label for="mitZahlen" name="mitZahlenLabel">With numbers?</label></td>
                  <td><input type="checkbox" name="mitZahlen" value="<?php echo $options->mitZahlen;?>" <?php echo $options->mitZahlen == '1' ? "checked" : "";?>/></td>
                  <td><small>Digits 0 - 9 </small></td>
                </tr>
                <tr class="specialcharacters-row">
                  <td><label for="mitSonderzeichen" name="mitSonderzeichenLabel">With special characters?</label></td>
                  <td><input type="checkbox" name="mitSonderzeichen" value="<?php echo $options->mitSonderzeichen;?>" <?php echo $options->mitSonderzeichen == '1' ? "checked" : "";?>/></td>
                  <td><small>Characters: <?php echo Options::SONDERZEICHENSTRING;?></small></td>
                </tr>
              </table>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block create-account">Generate Password</button>
            </div>

        <?php 
          if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $options->anzahlZeichen = ($_POST['anzahlZeichen']);
            $options->mitZahlen = isset($_POST['mitZahlen']) ? '1' : '0';
            $options->mitSonderzeichen = isset($_POST['mitSonderzeichen']) ? '1' : '0';

            $rand = $options->generatePassword($options);
            
            while ($options->isPasswortOkay($rand) == '0') {
              $rand = $options->generatePassword($options);
            }

            echo '<center>';

            echo '<div class="headline-master margin-top-50">Generated password:</div>';
            echo '<div class="password-main-value margin-bottom-30">' . $rand . '</div>';

            echo '<div class="headline-sub">md5-value:</div>';
            echo '<div class="password-value margin-bottom-30">' . hash('md5', $rand) . '</div>';

            echo '<div class="headline-sub">sha1-value:</div>';
            echo '<div class="password-value">'. hash('sha1', $rand) . '</div>';

            echo '</center>';
          } 
        ?>

        </form>
        <div class="social-media">
            <h5>made with &hearts; by magicmarcy</h5>
            <div class="social-icons">
                <a href="https://github.com/magicmarcy/yapg" target="_blank"><i class="icon-social-github" title="Project on Github"></i></a>
                <a href="https://twitter.com/magic_marcy"><i class="icon-social-twitter" title="Me on Twitter"></i></a>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</body>
</html>
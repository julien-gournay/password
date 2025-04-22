<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de mdp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bgcadre">
        <div class="test">
        <h1>Générateur de mot de passe</h1>
        <h3>Choisi les paramètres de ton mot de passe</h3>

        <form action="" method="POST">
            <div class="cadreOption">
                <label for="">Majuscules (A-Z)</label>
                <input type="checkbox" name="maj">
            </div>
            <div class="cadreOption">
                <label for="">Minuscules (a-z)</label>
                <input type="checkbox" name="min">
            </div>
            <div class="cadreOption">
                <label for="">Nombres (0-9)</label>
                <input type="checkbox" name="num">
            </div>
            <div class="cadreOption">
                <label for="">Symboles (&)</label>
                <input type="checkbox" name="sym">
            </div>
            <!--<input type="range" name="nbcarac" min="5" max="30" require/>
            <label for="ncarac">Nombre de caractère</label>-->

            <input type="numbers" name="ncarac" min="5" placeholder="Nombre de caractère" require>
            <button type="submit">Générer</button>
            <button type="reset">Effacer</button><br><br>
    

            <?php
                if (empty($_POST['ncarac'])) {
                    $v = 5;
                }
                elseif (isset($_POST['ncarac'])) {
                    $v = $_POST['ncarac'];
                } 


                if($v==0){
                    $n = 0;
                    echo("<p class='p'>Vous n'avez saisi aucun valeur, le mot de passe ne peut etre généré.</p><br>");
                }
                elseif($v<5){
                    $n = 5;
                    echo("<p class='p'>Le mots de passe doit contenir au moins 5 caractères.</p><br>");
                }
                else{
                    $n = $v;
                    echo("<p class='p'>Le mot de passe contient $n caractères.</p><br>");
                }

                $option = ["1","2"];
                if(isset($_POST["maj"])){
                    array_push($option, "1");
                }
                if(isset($_POST["min"])){
                    array_push($option, "2");
                }
                if(isset($_POST["num"])){
                    array_push($option, "3");
                }
                if(isset($_POST["sym"])){
                    array_push($option, "4");
                }
                echo implode(", ", $option);


                
                /*function carac_aleatoire() {
                    $choix = rand (97,122);
                    $codeAscii= chr($choix);
                    return $codeAscii;
                }*/
                

                function carac_aleatoire() {
                    $choix = rand(1,4);
                    //$choix = array_rand($option):
                    // Lettres majuscules
                    if($choix == 1){
                        $codeAscii = rand(65,90);
                    }
                    // Lettres minuscules
                    elseif($choix == 2){
                        $codeAscii = rand(97,122);
                    }
                    // Chiffres
                    elseif($choix == 3){
                        $codeAscii = rand(48,57);
                    }
                    // Caractères
                    elseif($choix == 4){
                        $choix2 = rand(1,4);
                        if($choix2 == 1){
                            $codeAscii = 33;
                        }
                        elseif($choix2 == 2){
                            $codeAscii = 35;
                        }
                        elseif($choix2 == 3){
                            $codeAscii = 38;
                        }
                        elseif($choix2 == 4){
                            $codeAscii = 42;
                        }
                    }
                    return chr($codeAscii);
                }

                function mot_passe($n) {
                    $mdp = "";
                    for ($i = 0; $i < $n; $i++) {
                        $mdp .= carac_aleatoire();
                    }
                    return $mdp;
                }
                ?>

                <div class="mdp">
                    <?php
                        $mdp = mot_passe($n);
                        //echo("<p class='p'>Votre mot de passe généré : $mdp</p>");
                        echo("<p class='p'>$mdp</p>");
                    ?>
                </div>
                

        </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<input type="text">
<?php
/*
function carac_aleatoire() {
    $choix = rand (97,122);
    $codeAscii= chr($choix);
    return $codeAscii;
}
*/
function carac_aleatoire() {
    $choix = rand(1,4);
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

/*
function carac_choisi(){
    $t[0]=chr(33);
    $t[1]=chr(35);
    $t[2]=chr(38);
    $t[3]=chr(42);

    for($i=4;$i<14;$i++){
        $t[$i]=chr($i+44);
    }
    for($i=14;$i<40;$i++){
        $t[$i]=chr($i+51);
    }
    for($i=40;$i<66;$i++){
        $t[$i]=chr($i+57);
    }
    $nbA = rand(0,65);
    return $t[$nbA];
}
*/


function mot_passe($n) {
    $mdp = "";
    for ($i = 0; $i < $n; $i++) {
        $mdp .= carac_aleatoire();
    }
    return $mdp;
}

$mdp = mot_passe(5);
echo("Votre mot de passe généré : $mdp");

/*
function EstValide($mdp){

}
*/


?>
</body>
</html>
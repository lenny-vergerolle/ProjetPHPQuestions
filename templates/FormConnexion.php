<?php

echo "<head>
    <title>Connexion</title>
    <link rel='stylesheet' type='text/css' href='style/style.css'>
    </head>
    <body>
    <h1>Connexion</h1>
    <div class='connexion'>
     <form action='../index.php' method='post'>
        <label for='nom_utilisateur'>Nom d'utilisateur:</label>
        <input type='text' id='nom_utilisateur' name='nom_utilisateur' required>
        
        <button type='submit'>Se connecter</button>
    </form>
    </div>
   
    </body>
";


?>

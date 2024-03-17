<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
    <style>
        body {
            background-color: burlywood;
        }

        .container {
            /* width: 80%; */
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        h1, h2 {
            margin-bottom: 10px;
            color: #333;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: green;
        }


        button[type="button"] {
            width: auto;
            padding: 10px 20px;
            background-color: #28a745;
        }

       

        .crud{
            display: flex;
            gap: 30px;
            justify-content: center;
        }
       
    </style>
</head>
<body> 
<div class="container">
<h1>Tableau de bord administrateur</h1>
    <section class="bg">

        <div class="crud">
         <a href="update.php"> <button onclick="ajouterMemoire()">Ajout de mémoire</button></a>

         <a href="deletmod.php"> <button onclick="ajouterMemoire()">Modifier</button></a>

         <a href="gestion_users.php"> <button onclick="ajouterMemoire()">Gestion users</button></a>
    </div>
    </div>

    <h2>Bienvenue sur votre interface de CRUD</h2>
    
   

</body>
</html>

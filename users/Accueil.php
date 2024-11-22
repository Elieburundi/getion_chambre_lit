<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif; 
            padding-top: 100px; /* Space for fixed header */
            flex:1;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
			margin-bottom:50px;
            width: 100%;
            background-color: #f0f0f0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        h1 {
            background-color: darksalmon;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 24px;
        }

        .nav {
            background-color: #3498db;
            padding: 10px;
            text-align: center;
            white-space: nowrap;
            overflow-x: auto;
        }

        .nav a {
            text-decoration: none;
            padding: 8px 12px;
            color: white;
            background-color: #2980b9;
            margin: 0 5px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .nav a:hover {
            background-color: #27ae60;
        }

        @media (max-width: 768px) {
            .nav {
                padding: 5px;
            }
            .nav a {
                padding: 6px 8px;
                font-size: 14px;
            }
        }
        p {
            text-align: center; /* Centre le contenu du paragraphe */
        }
        footer{
            padding: 200px;
            text-align: center;
            margin: 30;
        }
    </style>
</head>
<body>
    <header class="header">
         <h1>BIENVENU SUR NOTRE SITE</h1>
         <p>
        <img src="logo.png" height="100px" width="100px">
        </p>
        <nav class="nav">
        <a href="contact.php">Contactez-nous</a>
        <a href="patient.php">Malade</a>
        <a href="affichagepublication.php">Affichage publication</a>
        <a href="affichagepatient.php">affichage patient</a>
        <a href="footer.php">footer</a>
        
        </nav>
    </header>
   
</body>
</html>


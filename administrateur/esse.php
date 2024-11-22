<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        function comparerMotpasse(message1, message2) {
            if (message1 == message2) {
                return "Le mot de passe est les memes.";
            } else {
                return "Le mot de passe est différent.";
            }
        }
        </script>
        <form>
         message1<input type="text" name="message1" id="idmessage1" onblur="comparerMotpasse(message1);"/><br>
         message2<input type="text" name="message2" id="idmessage2" onblur="comparerMotpasse(message2);"/>
         
        </form>
</body>
</html>
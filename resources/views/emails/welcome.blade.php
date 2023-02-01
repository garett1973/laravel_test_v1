<html>
    <body>
        <h3>Welcome to the site, {{ $userName }}!</h3>
        <p>
           Your account has been created. You can login with the following credentials:
        </p>
        <p>
            Email: {{ $userEmail }} + your password<br>
        </p>
        <p>
            Or:
        </p>
        <p>
            Phone: {{ $userPhone }} + your password<br>
        </p>
    </body>
</html>

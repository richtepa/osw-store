<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/static/main.css">
</head>

<body>
    <div id="header">
        <a href="/">Startpage</a>
        <?php if(empty($_SESSION["uid"])){ ?>
            <form action="/signIn/" method="post">
                <input name="user" type="text" placeholder="username / e-Mail">
                <input name="pwd" type="password" placeholder="password">
                <button name="submit" type="submit">SignIn</button>
            </form>
            <form action="/resetPassword/" method="post">
                <input name="email" type="text" placeholder="e-Mail">
                <button name="submit" type="submit">Reset Password</button>
            </form>
            <form action="/signUp/" method="post">
                <input name="email" type="email" placeholder="e-Mail">
                <input name="uid" type="text" placeholder="username">
                <input name="pwd" type="password" placeholder="password">
                <input name="pwd2" type="password" placeholder="repeat password">
                <button name="submit" type="submit">SignUp</button>
            </form>
        <?php } else { ?>
            <a href="/signOut/"><button>SignOut</button></a>
        <?php }?>
    </div>
    <hr>

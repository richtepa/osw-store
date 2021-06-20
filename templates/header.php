<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/static/main.css">
    <script src=/static/script.js></script>
</head>

<body>
    <div class="header">
        <a class="invisibleLink" href="/">
            <div id="logo">OSW-Store</div>
        </a>
        <?php if(empty($_SESSION["uid"])){ ?>
        <div id="signin" onclick="toggleSignInUp()" style="margin-left: auto">Sign In/Up</div>
        <?php } else { ?>
        <div id="upload" onclick="toggleUpload()">Upload</div>
        <div id="signin"><a class="invisibleLink" href="/signOut/">Sign Out</a></div>
        <?php } ?>
    </div>
    
    <div class="dialogs">
        <div id="signInUp-dialog" class="dialog invisible">
            <div class="dialogBackground" onclick="toggleSignInUp()"></div>
            <div class="dialogForeground">
                <div class="dialogSection">
                    <form action="/signIn/" method="post">
                        <h3>Sign In</h3>
                        <table>
                            <tr>
                                <td class="inputDescription">Username or Email</td>
                                <td><input name="user" type="text"></td>
                            </tr>
                            <tr>
                                <td class="inputDescription">Password</td>
                                <td><input name="pwd" type="password"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> <button name="submit" type="submit">Sign In</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="line" style="height:0px; width:calc(50% - 2vw); border-bottom:5px solid gray; top: 50%;"></div>
                <div class="dialogSection" style="top:50%;">
                    <h3>Reset Password</h3>
                    <div>
                        You will get an Email with a link to reset your password.
                        <br><br>
                    </div>
                    <form action="/resetPassword/" method="post">
                        <table>
                            <tr>
                                <td class="inputDescription">Email</td>
                                <td><input name="email" type="text"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button name="submit" type="submit">Send Email</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="line" style="height:calc(100% - 4vw); width:0x; border-left:5px solid gray; left: 50%;"></div>
                <div class="dialogSection" style="left:55%;height:calc(100% - 4vw)">
                    <h3>Sign Up</h3>
                    <form action="/signUp/" method="post">
                        <table>
                            <tr>
                                <td class="inputDescription">Email</td>
                                <td><input name="email" type="email"></td>
                            </tr>
                            <tr>
                                <td class="inputDescription">Username</td>
                                <td><input name="uid" type="text"></td>
                            </tr>
                            <tr>
                                <td class="inputDescription">Password</td>
                                <td><input name="pwd" type="password"></td>
                            </tr>
                            <tr>
                                <td class="inputDescription">Repeat Password</td>
                                <td><input name="pwd2" type="password"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button name="submit" type="submit">Sign Up</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="upload-dialog" class="dialog invisible">
            <div class="dialogBackground" onclick="toggleUpload()"></div>
            <div class="dialogForeground">
                <div class="dialogSection" style="width:calc(100% - 4vw);height:calc(100% - 4vw);">
                    <h3>Upload Watchface:</h3>
                    <form action="/watchface/upload/" method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name</td>
                                <td><input name="title" type="text"></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td><textarea name="description" rows="3"></textarea></td>
                            </tr>
                            <tr>
                                <td>Screenshot</td>
                                <td><input type="file" accept="image/jpg,image/png, image/jpeg" name="screenshot"></td>
                            </tr>
                            <tr>
                                <td>Header (.h)</td>
                                <td><input type="file" accept=".h" name="header"></td>
                            </tr>
                            <tr>
                                <td>Code (.cpp)</td>
                                <td><input type="file" accept=".cpp" name="code"></td>
                            </tr>
                            <tr><td></td><td><button name="submit" type="submit">Upload</button></td></tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
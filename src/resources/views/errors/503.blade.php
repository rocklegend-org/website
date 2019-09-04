<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600' rel='stylesheet' type='text/css'>
    <style type="text/css">
        *{
            font-family: 'Source Sans Pro';
        }

        body{
            margin: 0;
            padding: 0;
        }

        .topbar{
            position: fixed;
            bottom: 0; left: 0;
            right: 0;

            height: 2px;

            background-color: rgb(212,40,77);
        }

        .center{
            position:absolute;
            left: 50%;
            top: 50%;

            transform: translate(-50%,-50%);

            text-align: center;

            font-size: 16px;
        }

        .thin{
            font-weight: 200;
        }

        a{
            text-decoration: none;
            color: #86CA34;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="topbar"></div>
    <div class="center">
        <a href="http://rocklegend.org">
            <img src="http://rocklegend.org/assets/images/frontend/logo.png" height="80">
        </a>
        <p><strong>Maintenance!</strong><br />
            We're currently performing an update!<br />
            Check back soon to find out what's new!
        </p>
        <p class="thin"><a href="{{url('')}}">try again</a></p>
    </div>
</body>
</html>
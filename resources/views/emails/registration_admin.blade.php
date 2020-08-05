<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <title></title> 
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }
    </style>


    <style>

        .primary{
            background: #0d0cb5;
        }
        .bg_white{
            background: #ffffff;
        }
        .bg_light{
            background: #fafafa;
        }
        .bg_black{
            background: #000000;
        }
        .bg_dark{
            background: rgba(0,0,0,.8);
        }
        .email-section{
            padding:2.5em;
        }

        /*BUTTON*/
        .btn{
            padding: 5px 15px;
            display: inline-block;
        }
        .btn.btn-primary{
            border-radius: 5px;
            background: #0d0cb5;
            color: #ffffff;
        }
        .btn.btn-white{
            border-radius: 5px;
            background: #ffffff;
            color: #000000;
        }
        .btn.btn-white-outline{
            border-radius: 5px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Poppins', sans-serif;
            color: #000000;
            margin-top: 0;
        }

        body{
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        }

        a{
            color: #0d0cb5;
        }

        table{
        }
        /*LOGO*/

        .logo h1{
            margin: 0;
        }
        .logo h1 a{
            color: #000000;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }

        .navigation{
            padding: 0;
        }
        .navigation li{
            list-style: none;
            display: inline-block;;
            margin-left: 5px;
            font-size: 13px;
            font-weight: 500;
        }
        .navigation li a{
            color: rgba(0,0,0,.4);
        }

        /*HERO*/
        .hero{
            position: relative;
            z-index: 0;
        }
        .hero .overlay{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            width: 100%;
            background: #000000;
            z-index: -1;
            opacity: .3;
        }
        .hero .icon{
        }
        .hero .icon a{
            display: block;
            width: 60px;
            margin: 0 auto;
        }
        .hero .text{
            color: rgba(255,255,255,.8);
        }
        .hero .text h2{
            color: #ffffff;
            font-size: 30px;
            margin-bottom: 0;
        }


        /*HEADING SECTION*/
        .heading-section{
        }
        .heading-section h2{
            color: #000000;
            font-size: 20px;
            margin-top: 0;
            line-height: 1.4;
            font-weight: 700;
            text-transform: uppercase;
        }
        .heading-section .subheading{
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(0,0,0,.4);
            position: relative;
        }
        .heading-section .subheading::after{
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: '';
            width: 100%;
            height: 2px;
            background: #0d0cb5;
            margin: 0 auto;
        }

        .heading-section-white{
            color: rgba(255,255,255,.8);
        }
        .heading-section-white h2{
            /* font-family:  */
            line-height: 1;
            padding-bottom: 0;
        }
        .heading-section-white h2{
            color: #ffffff;
        }
        .heading-section-white .subheading{
            margin-bottom: 0;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.4);
        }


        .icon{
            text-align: center;
        }
        .icon img{
        }


        /*SERVICES*/
        .services{
            background: rgba(0,0,0,.03);
        }
        .text-services{
            padding: 10px 10px 0; 
            text-align: center;
        }
        .text-services h3{
            font-size: 16px;
            font-weight: 600;
        }

        .services-list{
            padding: 0;
            margin: 0 0 20px 0;
            width: 100%;
            float: left;
        }

        .services-list img{
            float: left;
        }
        .services-list .text{
            width: calc(100% - 60px);
            float: right;
        }
        .services-list h3{
            margin-top: 0;
            margin-bottom: 0;
        }
        .services-list p{
            margin: 0;
        }

        /*BLOG*/
        .text-services .meta{
            text-transform: uppercase;
            font-size: 14px;
        }

        /*TESTIMONY*/
        .text-testimony .name{
            margin: 0;
        }
        .text-testimony .position{
            color: rgba(0,0,0,.3);

        }


        /*VIDEO*/
        .img{
            width: 100%;
            height: auto;
            position: relative;
        }
        .img .icon{
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            bottom: 0;
            margin-top: -25px;
        }
        .img .icon a{
            display: block;
            width: 60px;
            position: absolute;
            top: 0;
            left: 50%;
            margin-left: -25px;
        }



        /*COUNTER*/
        .counter{
            width: 100%;
            position: relative;
            z-index: 0;
        }
        .counter .overlay{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            width: 100%;
            background: #000000;
            z-index: -1;
            opacity: .3;
        }
        .counter-text{
            text-align: center;
        }
        .counter-text .num{
            display: block;
            color: #ffffff;
            font-size: 34px;
            font-weight: 700;
        }
        .counter-text .name{
            display: block;
            color: rgba(255,255,255,.9);
            font-size: 13px;
        }


        /*FOOTER*/

        .footer{
            color: rgba(255,255,255,.5);

        }
        .footer .heading{
            color: #ffffff;
            font-size: 20px;
        }
        .footer ul{
            margin: 0;
            padding: 0;
        }
        .footer ul li{
            list-style: none;
            margin-bottom: 10px;
        }
        .footer ul li a{
            color: rgba(255,255,255,1);
        }


        @media screen and (max-width: 500px) {

            .icon{
                text-align: left;
            }

            .text-services{
                padding-left: 0;
                padding-right: 20px;
                text-align: left;
            }

        }
    </style>
</head>
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
    <center style="width: 100%; background-color: #f1f1f1;">
        <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tbody>
                    <tr>
                        <td valign="top" class="bg_white" style="padding: 1em 2.5em;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="40%" class="logo" style="text-align: left;">
                                            <h1><a href="#">Corporate</a></h1>
                                        </td>
                                        <td width="60%" class="logo" style="text-align: right;">
                                            <ul class="navigation">
                                                <li><a href="#">Home</a></li>
                                                <li><a href="#">About</a></li>
                                                <li><a href="#">Works</a></li>
                                                <li><a href="#">Blog</a></li>
                                                <li><a href="#">Contact</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" class="hero bg_white" style="background-image: url({{ asset('/img/bg_1.jpg') }}); background-size: cover; height: 400px;">
                            <div class="overlay"></div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="text" style="padding: 0 3em; text-align: center;">
                                                <h2>We Create Modern Website</h2>
                                                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                                                <div class="icon">
                                                    <a href="#">
                                                        <img src="{{ asset('/img/002-play-button.png') }}" alt="" style="width: 60px; max-width: 600px; height: auto; margin: auto; display: block;">
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg_white">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="bg_white email-section">
                                            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                                <h2>{{ $customer->name }} has registered in MyBlogs just now!</h2>
                                                <p>Here are his details:</p>
                                                <p>Name: <span>{{ $customer->name }}</span></p>
                                                <p>Phone number: <span>{{ $customer->phone }}</span></p>
                                                <p>Email: <span>{{ $customer->email }}</span></p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tbody>
                    <tr>
                        <td valign="middle" class="bg_black footer email-section">
                            <table>
                                <tbody>
                                    <tr>
                                        <td valign="top" width="33.333%" style="padding-top: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <h3 class="heading">About</h3>
                                                            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" width="33.333%" style="padding-top: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: left; padding-left: 5px; padding-right: 5px;">
                                                            <h3 class="heading">Contact Info</h3>
                                                            <ul>
                                                                <li><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                                                                <li><span class="text">+2 392 3929 210</span></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" width="33.333%" style="padding-top: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tbody> 
                                                    <tr>
                                                        <td style="text-align: left; padding-left: 10px;">
                                                            <h3 class="heading">Useful Links</h3>
                                                            <ul>
                                                                <li><a href="#">Home</a></li>
                                                                <li><a href="#">About</a></li>
                                                                <li><a href="#">Services</a></li>
                                                                <li><a href="#">Work</a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" class="bg_black footer email-section">
                            <table>
                                <tbody>
                                    <tr>
                                        <td valign="top" width="33.333%">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <p>© 2018 Corporate. All Rights Reserved</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" width="33.333%">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: right; padding-left: 5px; padding-right: 5px;">
                                                            <p><a href="#" style="color: rgba(255,255,255,.4);">Unsubcribe</a></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
</body>
</html>
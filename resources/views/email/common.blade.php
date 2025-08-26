<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /* Reset styles */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        table {
            border-collapse: collapse !important;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f8f8f8;
        }
        /* Gmail Fix */
        div[style*="margin: 16px 0"] { margin:0 !important; }

        /* Responsive for mobile */
        @media screen and (max-width: 600px) {
            .responsive-table {
                width: 100% !important;
            }
            .padding {
                padding: 10px !important;
            }
        }
    </style>
</head>
<body style="background-color:#f8f8f8;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" style="padding: 20px 0;">
                    <!-- Container -->
                    <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table" style="background: #ffffff; border-radius: 6px; overflow: hidden;">
                        <!-- Header -->
                        <tr>
                            <td align="center" style="padding: 20px;">
                                <img src="{{ get_file(sidebar_logo()) }}" width="110" alt="Logo" style="display: block;">
                            </td>
                        </tr>
                        <!-- Separator -->
                        <tr>
                            <td style="border-top: 7px solid #6676EF;"></td>
                        </tr>
                        <!-- Content -->
                        <tr>
                            <td style="padding: 30px 50px;" class="padding">
                                @yield('content')
                            </td>
                        </tr>
                        <!-- Footer -->
                        <tr>
                            <td style="padding: 20px; font-size: 12px; color: #999999; text-align: center;">
                                &copy; {{ date('Y') }} Your Company. All rights reserved.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>

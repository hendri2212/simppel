<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Device Sign-in</title>
    <style type="text/css">
        /* Reset styles */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            max-width: 100%;
            display: block;
        }

        body {
            width: 100% !important;
            min-width: 100%;
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        /* Include padding in width */

        /* Responsive styles for iPhone 12 Pro and later (~390px and up) */
        @media only screen and (max-width: 430px) {

            /* Covers iPhone 12 Pro to 15 Pro Max */
            .container {
                width: 100% !important;
                max-width: 100% !important;
            }

            .content {
                padding: 15px !important;
            }

            /* Reduced padding to fit narrow screens */
            .header {
                padding: 15px !important;
            }

            .button {
                padding: 10px 20px !important;
                font-size: 14px !important;
                max-width: 90% !important;
                display: block;
                margin: 0 auto;
            }

            /* Center and constrain button */
            .code {
                font-size: 28px !important;
                letter-spacing: 4px !important;
                padding: 12px !important;
                margin: 20px auto 30px !important;
                max-width: 90% !important;
            }

            /* Constrain code width */
            h2 {
                font-size: 18px !important;
                margin-bottom: 10px !important;
            }

            p {
                font-size: 13px !important;
                margin: 10px 0 !important;
            }

            .footer td {
                font-size: 11px !important;
                padding: 10px !important;
            }

            .logo {
                padding-bottom: 20px !important;
            }

            table,
            td {
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Force fit */
        }
    </style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; width: 100%;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f5f5f5; max-width: 600px;">
        <tr>
            <td align="center" style="padding: 20px;">
                <!-- Main content table -->
                <table class="container" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 8px; padding: 20px; max-width: 600px; width: 100%;">
                    <tr>
                        <td align="center" class="logo" style="padding-bottom: 20px;">
                            <img src="logo.svg" alt="SmartAdmin Logo" width="80" height="80" style="display: block; border: 0; max-width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="header" style="padding: 20px; background: #fafafa; border-radius: 4px;">
                            <h2 style="text-align: center; margin: 0; font-size: 24px; color: #333333; font-family: Arial, Helvetica, sans-serif;">We received a request to reset your password.</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="content" style="padding: 20px; text-align: center;">
                            <p style="font-size: 16px; color: #007bff; margin: 0 0 15px; text-align: center; font-family: Arial, Helvetica, sans-serif;">Login to SmartAdmin with this magic link</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 10px 0;">
                                        <a href="#" class="button" style="display: inline-block; background-color: #2196F3; color: #ffffff; padding: 12px 24px; font-size: 16px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Click here to log in</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 14px; color: #666666; margin: 20px 0 5px; text-align: center; font-family: Arial, Helvetica, sans-serif;">Or, copy and paste this temporary login code:</p>
                            <p class="code" style="font-size: 50px; color: #000000; margin: 15px 0 30px; text-align: center; background-color: #f8f9fa; padding: 15px 25px; border-radius: 17px; font-weight: bold; letter-spacing: 10px; display: inline-block; font-family: Arial, Helvetica, sans-serif;">12654</p>
                            <p style="font-size: 14px; color: #666666; margin: 0; text-align: center; font-family: Arial, Helvetica, sans-serif;">If you didn’t try to login, you can safely ignore this email.</p>
                        </td>
                    </tr>
                </table>
                <!-- Footer table -->
                <table class="container footer" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px; text-align: center; max-width: 600px; width: 100%;">
                    <tr>
                        <td style="padding: 10px;">
                            <h3 style="font-size: 16px; margin: 10px 0; color: #333333; font-family: Arial, Helvetica, sans-serif;">SmartAdmin Inc.</h3>
                            <p style="font-size: 14px; color: #666666; margin: 0; font-family: Arial, Helvetica, sans-serif;">Sent with ♥️ from SmartAdmin Inc.<br>SmartAdmin Rd, SA-Alpha<br>California, 45673, USA</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
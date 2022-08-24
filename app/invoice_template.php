<?php

// Border Style top right bottom left
$bt = 'border-top: 1px solid #000;';
$br = 'border-right: 1px solid #000;';
$bb = 'border-bottom: 1px solid #000;';
$bl = 'border-left: 1px solid #000;';


$html = "
<table cellpadding=\"10\" cellspacing=\"0\">
    <tbody>
        <tr>
            <td><strong>$s_name</strong></td>
            <td align=\"right\" style=\"color:#341f97\"><strong>FAKTURA č. $faktura</strong></td>
        </tr>
        <tr>
            <td style=\"$bl $bt $br\"><table cellpadding=\"0\" border=\"0\" style=\"border-collapse: collapse\" width=\"100%\">
                    <tbody>
                        <tr>
                            <td width=\"40%\" valign=\"top\" style=\"padding: 10px\"><span style=\"color:#341f97\">Dodavatel:</span>
                                <br><img src=\"../img/logo.png\" width=\"100px\">
                            </td>
                            <td width=\"60%\" style=\"padding: 10px\">
                                <br><strong>$s_name</strong>
                                <br><strong>$s_address</strong>
                                <br><br>
                                <br><span style=\"color:#341f97\">IČ: $supplier</span>
                                <br>Telefon: $s_phone
                                <br>Mobil:
                                <br>E-mail: <a href=\"mailto:$s_email\">$s_email</a>
                                <br><a href=\"https://www.naseandulka.cz/\">www.naseandulka.cz</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style=\"border-right: 3px solid #000; border-top: 3px solid #000; border-left: 3px solid #000\" valign=\"bottom\"><table cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"border-collapse: collapse\">
                    <tbody>
                        <tr valign=\"top\">
                            <td>Variabilní s.: $faktura
                                <br>Objednávka č.:
                                <br>Objednávka ze dne:
                                <br><br><br>
                            </td>
                            <td align=\"right\">Konstantní s.: 0308</td>
                        </tr>
                        <tr>
                            <td><span style=\"color:#341f97\">Odběratel:&nbsp;</span> IČ:
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DIČ:
                            </td>
                            <td valign=\"top\" align=\"right\">$receiver</td>
                        </tr>
                        <tr>
                            <td>
                                <br><br><br><strong>$r_name
                                    <br>$r_address<br>CZ
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"border: 3px solid #000;\">Banka:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $s_bankName
                <br>SWIFT:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $s_swift
                <br>IBAN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $s_iban
                <br>Číslo účtu:&nbsp;&nbsp;&nbsp; $cislo_uctu
                <br>Kód banky:&nbsp;&nbsp; $s_bankCode
            </td>
            <td style=\"border-right: 3px solid #000; border-bottom: 3px solid #000\"></td>
        </tr>
        <tr>
            <td style=\"$bl $br $bb $bt\">
                <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
                    <tbody>
                        <tr>
                            <td>Datum splatnosti:&nbsp;&nbsp;&nbsp;</td>
                            <td align=\"right\" width=\"70px\" style=\"$bt $br $bb $bl\">$date_splatnosti</td>
                        </tr>
                        <tr>
                            <td>Datum vystavení:&nbsp;&nbsp;&nbsp;</td>
                            <td align=\"right\" style=\"$br $bb $bl\">$date_vystaveni</td>
                        </tr>
                        <tr>
                            <td>Firma není plátcem DPH.&nbsp;&nbsp;&nbsp;</td>
                            <td align=\"right\" style=\"$br $bb $bl\"></td>
                        </tr>
                        <tr>
                            <td>Forma úhrady:&nbsp;&nbsp;&nbsp;</td>
                            <td align=\"right\">Převodem</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style=\"$br $bb $bt\" valign=\"top\"><span style=\"color:#341f97\">Konečný příjemce:</span></td>
        </tr>
        <tr>
            <td style=\"$bl\">Označení dodávky</td>
            <td style=\"$br $bb\" rowspan=\"2\">
                <table cellpadding=\"0\" width=\"100%\">
                    <tbody>
                        <tr>
                            <td align=\"right\">Množství</td>
                            <td align=\"right\">J.cena Kč</td>
                            <td align=\"right\">Celkem</td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td align=\"right\">1</td>
                            <td align=\"right\">$amount</td>
                            <td align=\"right\">$amount</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"$bl $bb\"><span style=\"color:#341f97\">Zajištění úklidu 08/2022</span></td>
        </tr>
        <tr>
            <td style=\"$bl\">Součet položek</td>
            <td style=\"$br\" align=\"right\">$amount</td>
        </tr>
        <tr>
            <td style=\"$bl\"><strong>CELKEM K ÚHRADĚ</strong></td>
            <td style=\"$br\">
                <table width=\"100%\">
                    <tbody>
                        <tr>
                            <td>Částky jsou uvedeny v <strong>Kč</strong></td>
                            <td align=\"right\"><strong>$amount</strong></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"$bl $br $bt\" colspan=\"2\">Vystavil: $s_name <br><br><br></td>
        </tr>
        <tr>
            <td style=\"$bl $br\" colspan=\"2\">Vydané jménem Monikou Kuchyňkovou firmou:
                <br>$s_address
                <br>IČO: $supplier
            </td>
        </tr>
        <tr>
            <td style=\"$bt $bl\">
                <br><br><br><br><br><br><br><br><br><br><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QR Platba+F
            </td>
            <td style=\"$bt $br\">
                <table width=\"100%\">
                    <tbody>
                        <tr>
                            <td><br><br><br><br><br><br><br><br><br>Převzal:</td>
                            <td><br><br><br><br><br><br><br><br><br>Razítko:</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"$bb $bl\">Vystaveno v mobilní fakturaci <a href=\"https://www.mpohoda.cz/\">www.mpohoda.cz</a></td>
            <td style=\"$bb $br\" align=\"right\">Ekonomický a informační systém POHODA</td>
        </tr>
    </tbody>
</table>
";
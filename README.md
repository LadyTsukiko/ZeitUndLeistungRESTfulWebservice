# ZeitUndLeistungWebservice
Webservice für die Verbindung zur Datenbank
 
<table>
<tr>
    <td>/erfassung</td>
    <td>Nimmt die übergebenen Parameter und speichert sie als Zeiterfassung in der DB. Gibt Json mit error=true/false zurück</td>
</tr>
<tr>
    <td>/get</td>
    <td>Keine Parameter, gibt ein Json mit einem Array für Projekte und einem für Leistungen zurück, oder error=true</td>
</tr>
<tr>
    <td>/login</td>
    <td>Nimmt Passwort und ID als Parameter und vergleicht mit der DB. Returns Json mit error=true/false und Username oder Errormessage </td>
</tr>
</table>

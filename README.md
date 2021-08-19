<p align="center">
 <img width="400" src="images/logo.png?token=AGGN6WZMSPUPDIMJ3OVVJADBDWSNQ">
 <br><br>
 Welcome to the unofficial OSTicket API!<br>
 The purpose of this API is to help the community and leverage the use of OSTicket.
</p>

## How to Use
To use OSTicket Unofficial API you have to place the `ost_wbs` directory in the root of OSTicket server.<br>
Then, go to `ost_wbs > config.php` and change the DB credentials.

Use the following URL: `{YOUR-DOMAIN}/ost_wbs/?`

<b>NOTE</b>: If you dont know the credentials, go to `/include/ost-config.php`. That is the main config file for OSTicket system.

## Authentication
In all requests, the API key that was created in the OSTicket system must be sent to authenticate the user.<br>

| Option | Type | Mandatory | Description
| --- | --- |  :-: |  --- |
| `apikey`| string | ✅ | Official API-Key generated in OSTicket System |

<b>Example</b>:

`{YOUR-DOMAIN}/ost_wbs/?apikey={API-KEY}`

## Ticket Info

### 🔘 Specific Number/ID
You can fetch all info from a specific ticket using the ID or ID Number, for example:

`{YOUR DOMAIN}/ost_wbs/?apikey={API-KEY}&query=ticket&condition=specific&parameters={TICKET-ID/TICKET-NUMBER}`

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `parameters`| `int` or `string` | `ID` or `Number` | ✅ | Indicates specific ID or Number |

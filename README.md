<p align="center">
 <img width="400" src="images/logo.png?token=AGGN6WZMSPUPDIMJ3OVVJADBDWSNQ">
 <br><br>
 Welcome to the unofficial OSTicket API!<br>
 The purpose of this API is to help the community and leverage the use of OSTicket.
</p>


## Tested Versions
This api was tested in the following versions:

| Version |
| --- |
| `v1.14.3`|

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

### 🔘 Specific Ticket
You can fetch all info from a specific ticket using the ID or ID Number, for example:

`{YOUR DOMAIN}/ost_wbs/?apikey={API-KEY}&query=ticket&condition=specific&parameters={TICKET-ID/TICKET-NUMBER}`

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `parameters`| `int` or `string` | `ID` or `Number` | ✅ | Indicates specific ID or Number |


### 🔘 By Status
You can fetch all tickets based on the current status, for example:

`{YOUR DOMAIN}/ost_wbs/?apikey={API-KEY}&query=ticket&condition=all&sort=status&parameters={TICKET-STATUS-ID}`

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `sort`|  `string` | `status` | ✅ | Indicates the type of search |
| `parameters`| `int` or `string` | `Ticket Status ID` | ✅ | Ticket status ID you want to search for |

Available ticket status:

| Option | Name |
| --- | --- |
| `0`| `1` |
| `1`| `Open` |
| `2`|  `Resolved` |
| `3`| `Closed` |
| `4`| `Archived` |
| `5`|  `Deleted` |
| `6`| `On Going` |
| `7`| `Pending` |

### 🔘 Between Dates
You can fetch all tickets by creation between two given dates, for example:

`{YOUR DOMAIN}/ost_wbs/?apikey={API-KEY}&query=ticket&condition=all&sort=date&parameters={START-DATEtoEND-DATE}`

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `sort`|  `string` | `date` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01` | ✅ | Date interval that all tickets will be fetched |

